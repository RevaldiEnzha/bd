@extends('layouts.app')

@section('content')
<div class="sweet-container">
    <header class="hero-header">
        <div class="badge-tag">
            Mini Game
        </div>
        <h1 class="hero-title">Tangkap Kado & Stroberi</h1>
        <p class="hero-subtitle">Gerakkan keranjang untuk menangkap kue dan stroberi! Kumpulkan 200 poin untuk membuka sertifikat rahasia</p>
    </header>

    <div class="sweet-card game-arena">
        <!-- Game HUD -->
        <div class="game-hud">
            <div class="hud-item">
                ⭐ Skor: <span id="gameScore">0</span> / 200
            </div>
            <div class="hud-item" style="color: #ff6b8b;">
                💖 Nyawa: <span id="gameLives">❤️❤️❤️</span>
            </div>
            <button type="button" id="btnRestartGame" class="btn-sweet-secondary" style="font-size: 0.8rem; padding: 4px 12px;">
                🔄 Main Lagi
            </button>
        </div>

        <!-- Canvas Container -->
        <div class="canvas-container">
            <canvas id="gameCanvas" width="400" height="340"></canvas>
        </div>

        <!-- Mobile On-Screen Touch Buttons (Easy thumb play on smartphones!) -->
        <div class="mobile-game-controls">
            <button type="button" class="btn-game-touch" id="btnTouchLeft">
                <span>⬅️</span> Kiri
            </button>
            <button type="button" class="btn-game-touch" id="btnTouchRight">
                Kanan <span>➡️</span>
            </button>
        </div>

        <br>

        <!-- Certificate Awarded upon reaching 200 pts -->
        <div class="certificate-wrapper" id="certificateBox">
            <div style="font-size: 3rem; margin-bottom: 2px;">🎖️</div>
            <span style="font-size: 0.85rem; font-weight: 700; color: #b78103; letter-spacing: 1.5px;">PENGHARGAAN RESMI ULANG TAHUN</span>
            <h2 class="cert-title">Sertifikat Orang Paling Keren di Dunia</h2>
            <p style="font-size: 0.95rem; color: #6b5344; margin-top: 6px;">Diberikan dengan penuh rasa hormat dan bangga kepada:</p>
            
            <div class="cert-recipient">
                {{ $settings['name'] ?? 'Bidadari Manis' }}
            </div>

            <p style="font-size: 0.9rem; color: #5c4738; max-width: 460px; margin: 0 auto 16px; line-height: 1.5;">
                Atas prestasinya selalu menjadi teman yang baik, selalu menghibur, 
                dan resmi bertambah usia yang ke-<strong>{{ $settings['age'] ?? '21' }}</strong> 
            </p>

            <div style="display: flex; justify-content: space-around; align-items: center; margin-top: 20px; border-top: 2px dashed #e8d7c3; padding-top: 12px;">
                <div>
                    <span style="font-size: 0.75rem; color: var(--text-soft); display: block;">Tertanggal:</span>
                    <strong style="font-size: 0.88rem;">26 September 2026</strong>
                </div>
                <div>
                    <span style="font-size: 1.8rem;">🌸🧸👑</span>
                </div>
                <div>
                    <span style="font-size: 0.75rem; color: var(--text-soft); display: block;">Disahkan oleh:</span>
                    <strong style="font-family: var(--font-handwriting); font-size: 1.3rem; color: var(--accent);">Revaldi</strong>
                </div>
            </div>

            <div style="margin-top: 18px;">
                <button type="button" class="btn-sweet-primary" onclick="window.print()">
                    <span>🖨️</span> Cetak / Simpan Sertifikat
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const canvas = document.getElementById('gameCanvas');
    const ctx = canvas.getContext('2d');
    const scoreSpan = document.getElementById('gameScore');
    const livesSpan = document.getElementById('gameLives');
    const btnRestart = document.getElementById('btnRestartGame');
    const certBox = document.getElementById('certificateBox');
    const btnTouchLeft = document.getElementById('btnTouchLeft');
    const btnTouchRight = document.getElementById('btnTouchRight');

    let score = 0;
    let lives = 3;
    let isGameOver = false;
    let hasWon = false;
    let animationFrameId = null;

    const player = {
        x: canvas.width / 2 - 30,
        y: canvas.height - 46,
        width: 60,
        height: 34,
        speed: 7,
        emoji: '🧺'
    };

    const itemTypes = [
        { type: 'strawberry', emoji: '🍓', points: 10, speed: 2.2 },
        { type: 'cupcake', emoji: '🧁', points: 20, speed: 2.5 },
        { type: 'gift', emoji: '🎁', points: 50, speed: 2.8 },
        { type: 'star', emoji: '⭐', points: 100, speed: 3.4 },
        { type: 'cloud', emoji: '🌧️', points: -15, isHazard: true, speed: 2.0 }
    ];

    let items = [];
    let spawnTimer = 0;
    const keys = { left: false, right: false };

    // Keyboard controls
    window.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowLeft' || e.key === 'a' || e.key === 'A') keys.left = true;
        if (e.key === 'ArrowRight' || e.key === 'd' || e.key === 'D') keys.right = true;
    });

    window.addEventListener('keyup', (e) => {
        if (e.key === 'ArrowLeft' || e.key === 'a' || e.key === 'A') keys.left = false;
        if (e.key === 'ArrowRight' || e.key === 'd' || e.key === 'D') keys.right = false;
    });

    // Touch Buttons
    function bindTouchButton(btn, direction) {
        const start = (e) => {
            e.preventDefault();
            keys[direction] = true;
            if (window.sweetSFX) window.sweetSFX.blip();
        };
        const end = (e) => {
            e.preventDefault();
            keys[direction] = false;
        };

        btn.addEventListener('touchstart', start, { passive: false });
        btn.addEventListener('touchend', end, { passive: false });
        btn.addEventListener('mousedown', start);
        btn.addEventListener('mouseup', end);
        btn.addEventListener('mouseleave', end);
    }

    bindTouchButton(btnTouchLeft, 'left');
    bindTouchButton(btnTouchRight, 'right');

    // Canvas Touch / Mouse Drag
    function handlePointerMove(clientX) {
        const rect = canvas.getBoundingClientRect();
        const scaleX = canvas.width / rect.width;
        const targetX = (clientX - rect.left) * scaleX;
        player.x = Math.max(0, Math.min(canvas.width - player.width, targetX - player.width / 2));
    }

    canvas.addEventListener('mousemove', (e) => handlePointerMove(e.clientX));
    canvas.addEventListener('touchmove', (e) => {
        if (e.touches.length > 0) {
            handlePointerMove(e.touches[0].clientX);
        }
        e.preventDefault();
    }, { passive: false });

    function resetGame() {
        score = 0;
        lives = 3;
        isGameOver = false;
        hasWon = false;
        items = [];
        spawnTimer = 0;
        scoreSpan.textContent = '0';
        livesSpan.textContent = '❤️❤️❤️';
        certBox.style.display = 'none';
        if (animationFrameId) cancelAnimationFrame(animationFrameId);
        gameLoop();
    }

    btnRestart.addEventListener('click', () => {
        if (window.sweetSFX) window.sweetSFX.pop();
        resetGame();
    });

    function spawnItem() {
        const rand = Math.random();
        let selected;
        if (rand < 0.45) selected = itemTypes[0];
        else if (rand < 0.70) selected = itemTypes[1];
        else if (rand < 0.82) selected = itemTypes[4];
        else if (rand < 0.95) selected = itemTypes[2];
        else selected = itemTypes[3];

        items.push({
            x: Math.random() * (canvas.width - 36) + 10,
            y: -25,
            ...selected
        });
    }

    function gameLoop() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        // Move player
        if (keys.left && player.x > 0) player.x -= player.speed;
        if (keys.right && player.x < canvas.width - player.width) player.x += player.speed;

        // Draw Player
        ctx.font = '32px Arial';
        ctx.fillText(player.emoji, player.x + 12, player.y + 26);

        // Spawn
        spawnTimer++;
        if (spawnTimer % 45 === 0) {
            spawnItem();
        }

        // Draw & update items
        for (let i = items.length - 1; i >= 0; i--) {
            const item = items[i];
            item.y += item.speed;

            ctx.font = '26px Arial';
            ctx.fillText(item.emoji, item.x, item.y);

            // Collision
            if (
                item.y > player.y - 8 &&
                item.y < player.y + player.height &&
                item.x + 18 > player.x &&
                item.x < player.x + player.width
            ) {
                if (item.isHazard) {
                    lives--;
                    livesSpan.textContent = '❤️'.repeat(Math.max(0, lives));
                    if (window.sweetSFX) window.sweetSFX.boing();
                    showSweetToast('Jangan Kena awan! Hati-hati! 🌧️', '⚡');
                    if (lives <= 0) {
                        endGame(false);
                    }
                } else {
                    score += item.points;
                    scoreSpan.textContent = score;
                    if (window.sweetSFX) {
                        if (item.points >= 50) window.sweetSFX.chime();
                        else window.sweetSFX.pop(620);
                    }

                    if (score >= 200 && !hasWon) {
                        hasWon = true;
                        endGame(true);
                    }
                }
                items.splice(i, 1);
                continue;
            }

            if (item.y > canvas.height + 20) {
                items.splice(i, 1);
            }
        }

        if (!isGameOver) {
            animationFrameId = requestAnimationFrame(gameLoop);
        }
    }

    function endGame(won) {
        isGameOver = true;
        if (won) {
            if (window.sweetSFX) window.sweetSFX.fanfare();
            if (window.triggerConfetti) {
                window.triggerConfetti(window.innerWidth / 2, window.innerHeight / 2, 80);
            }
            certBox.style.display = 'block';
            certBox.scrollIntoView({ behavior: 'smooth' });
            showSweetToast('GOKIL 200 poin! Sertifikat terbuka! 🏆🎉', '👑');
        } else {
            ctx.fillStyle = 'rgba(255, 255, 255, 0.85)';
            ctx.fillRect(0, 0, canvas.width, canvas.height);
            ctx.fillStyle = '#ff477e';
            ctx.font = 'bold 20px Quicksand';
            ctx.textAlign = 'center';
            ctx.fillText('Nyawa Habis! Cupu!', canvas.width / 2, canvas.height / 2 - 8);
            ctx.font = '14px Quicksand';
            ctx.fillStyle = '#5c3d47';
            ctx.fillText('Sentuh "Main Lagi" untuk mencoba kembali!', canvas.width / 2, canvas.height / 2 + 20);
        }
    }

    resetGame();
});
</script>
@endsection
