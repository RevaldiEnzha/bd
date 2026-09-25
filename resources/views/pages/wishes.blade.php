@extends('layouts.app')

@section('content')
<div class="sweet-container">
    <header class="hero-header">
        <div class="badge-tag">
            Ucapan
        </div>
        <h1 class="hero-title">Harapan & Doa</h1>
        <p class="hero-subtitle">Setiap kata yang ditulis disini harus tulus dan nyata!</p>
    </header>

    <!-- Interactive Touch-Friendly Scratch Card -->
    <div class="sweet-card" style="text-align: center;">
        <h3 style="font-family: var(--font-heading); color: var(--accent); font-size: 1.35rem; margin-bottom: 4px;">
            🎫 Kartu Gosok Keberuntungan Ulang Tahun!
        </h3>
        <p style="font-size: 0.85rem; color: var(--text-soft); max-width: 440px; margin: 0 auto;">
            Gosok permukaan berkilau di bawah ini untuk melihat hadiah kejutan manis yang sudah disiapkan untukmu!
        </p>

        <div class="scratch-card-container">
            <div class="scratch-canvas-wrap">
                <div class="scratch-secret-content" id="scratchPrizeContent">
                    <span style="font-size: 2rem; margin-bottom: 2px;">🍦</span>
                    <span style="font-size: 1.05rem;" id="scratchPrizeTitle">Kupon 1x Traktir Es Krim!</span>
                    <span style="font-size: 0.78rem; font-weight: normal; margin-top: 2px;">Bisa ditukarkan kapan saja dengan pelukan! 🤗</span>
                </div>
                <canvas id="scratchCanvas" width="300" height="150"></canvas>
            </div>
            <button type="button" id="btnResetScratch" class="btn-sweet-secondary" style="font-size: 0.82rem; padding: 5px 16px; margin-top: 8px;">
                <span>✨</span> Ambil Tiket Hadiah Baru
            </button>
        </div>
    </div>

    <!-- Add Wish Section -->
    <div class="sweet-card" style="margin-top: 24px;">
        <div style="text-align: center; margin-bottom: 18px;">
            <div style="font-size: 2rem; margin-bottom: 2px;">✍️💌</div>
            <h3 style="font-family: var(--font-heading); color: var(--accent); font-size: 1.4rem;">
                Tulis Apa Aja Disini
            </h3>
            <p style="font-size: 0.85rem; color: var(--text-soft);">
                Tinggalkan ucapan!
            </p>
        </div>

        <form id="addWishForm" style="max-width: 520px; margin: 0 auto;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 10px;">
                <div>
                    <label style="font-weight: 700; font-size: 0.82rem; display: block; margin-bottom: 4px;">Nama / Panggilan:</label>
                    <input type="text" name="name" class="wish-input-box" placeholder="Contoh: Naufa / LingLing" required>
                </div>
                <div>
                    <label style="font-weight: 700; font-size: 0.82rem; display: block; margin-bottom: 4px;">Stiker Avatar:</label>
                    <select name="sticker" class="wish-input-box" style="cursor: pointer;">
                        <option value="💖">💖 Hati</option>
                        <option value="🧸">🧸 Boneka</option>
                        <option value="🌸">🌸 Bunga</option>
                        <option value="🍓">🍓 Stroberi</option>
                        <option value="🐱">🐱 Anak Kucing</option>
                        <option value="🐰">🐰 Kelinci</option>
                    </select>
                </div>
            </div>

            <div style="margin-bottom: 10px;">
                <label style="font-weight: 700; font-size: 0.82rem; display: block; margin-bottom: 4px;">Pesanmu:</label>
                <textarea name="message" class="wish-input-box" rows="3" placeholder="Tulis harapan atau doa atau candaan atau apalah..." required></textarea>
            </div>

            <div style="margin-bottom: 16px;">
                <label style="font-weight: 700; font-size: 0.82rem; display: block; margin-bottom: 6px;">Warna Kertas Sticky Note:</label>
                <div style="display: flex; gap: 10px; justify-content: center; flex-wrap: wrap;">
                    <label style="cursor: pointer; display: flex; align-items: center; gap: 4px; font-weight: 600; font-size: 0.82rem;">
                        <input type="radio" name="color" value="pink" checked>
                        <span style="display: inline-block; width: 18px; height: 18px; background: #ffe4e9; border: 2px solid #ffccd5; border-radius: 50%;"></span> Pink
                    </label>
                    <label style="cursor: pointer; display: flex; align-items: center; gap: 4px; font-weight: 600; font-size: 0.82rem;">
                        <input type="radio" name="color" value="lavender">
                        <span style="display: inline-block; width: 18px; height: 18px; background: #f0e6ff; border: 2px solid #dfccf9; border-radius: 50%;"></span> Lavender
                    </label>
                    <label style="cursor: pointer; display: flex; align-items: center; gap: 4px; font-weight: 600; font-size: 0.82rem;">
                        <input type="radio" name="color" value="peach">
                        <span style="display: inline-block; width: 18px; height: 18px; background: #ffebd9; border: 2px solid #ffd4b8; border-radius: 50%;"></span> Peach
                    </label>
                    <label style="cursor: pointer; display: flex; align-items: center; gap: 4px; font-weight: 600; font-size: 0.82rem;">
                        <input type="radio" name="color" value="mint">
                        <span style="display: inline-block; width: 18px; height: 18px; background: #e0f8f0; border: 2px solid #bdf1e1; border-radius: 50%;"></span> Mint
                    </label>
                </div>
            </div>

            <button type="submit" class="btn-sweet-primary" style="width: 100%; justify-content: center;">
                <span>💌</span> Tempelkan Ucapan ke Papan
            </button>
        </form>
    </div>

    <!-- Wishes Board Grid -->
    <div class="wish-board" id="wishBoard">
        @foreach ($wishes as $wish)
            <div class="wish-note color-{{ $wish->color ?? 'pink' }}" data-id="{{ $wish->id }}">
                <div class="note-pin">📌</div>
                <div>
                    <div class="wish-author">
                        <span>{{ $wish->sticker ?? '💖' }}</span>
                        <span>{{ $wish->name }}</span>
                    </div>
                    <div class="wish-text">
                        "{{ $wish->message }}"
                    </div>
                </div>
                <div class="wish-footer">
                    <span>🕒 {{ $wish->created_at ? $wish->created_at->format('d M, H:i') : '' }}</span>
                    <button type="button" class="like-button-badge btn-like-wish" data-id="{{ $wish->id }}" data-custom-sfx="true">
                        <span>💖</span> <span class="like-count">{{ $wish->likes }}</span>
                    </button>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    // 1. Touch-friendly Scratch Card
    const canvas = document.getElementById('scratchCanvas');
    const ctx = canvas.getContext('2d');
    const btnResetScratch = document.getElementById('btnResetScratch');
    const prizeContent = document.getElementById('scratchPrizeContent');
    const prizeTitle = document.getElementById('scratchPrizeTitle');

    const prizes = [
        { icon: '🍦', title: 'Kupon 1x Traktir Es Krim & Boba!' },
        { icon: '🤗', title: 'Voucher Pelukan Hangat Tanpa Batas!' },
        { icon: '🍰', title: 'Kupon Bebas Pilih Kue Favorit!' },
        { icon: '👑', title: 'Gelar: Orang Paling Menggemaskan di Dunia!' },
        { icon: '✨', title: 'Kupon Ditraktir Nonton Film Pilihanmu!' }
    ];

    let isScratching = false;
    let isRevealed = false;

    function initScratchCanvas() {
        isRevealed = false;

        const prize = prizes[Math.floor(Math.random() * prizes.length)];
        prizeContent.querySelector('span:first-child').textContent = prize.icon;
        prizeTitle.textContent = prize.title;

        ctx.globalCompositeOperation = 'source-over';
        const grad = ctx.createLinearGradient(0, 0, canvas.width, canvas.height);
        grad.addColorStop(0, '#c7c7c7');
        grad.addColorStop(0.5, '#e5e5e5');
        grad.addColorStop(1, '#b0b0b0');
        ctx.fillStyle = grad;
        ctx.fillRect(0, 0, canvas.width, canvas.height);

        ctx.fillStyle = '#ff6b8b';
        ctx.font = 'bold 14px Quicksand, sans-serif';
        ctx.textAlign = 'center';
        ctx.fillText('✨ Gosok Di Sini Untuk Hadiah! ✨', canvas.width / 2, canvas.height / 2 + 5);
    }

    function scratch(e) {
        if (!isScratching || isRevealed) return;

        const rect = canvas.getBoundingClientRect();
        const clientX = e.clientX !== undefined ? e.clientX : (e.touches && e.touches[0].clientX);
        const clientY = e.clientY !== undefined ? e.clientY : (e.touches && e.touches[0].clientY);
        
        // Scale appropriately with canvas resolution
        const scaleX = canvas.width / rect.width;
        const scaleY = canvas.height / rect.height;

        const x = (clientX - rect.left) * scaleX;
        const y = (clientY - rect.top) * scaleY;

        ctx.globalCompositeOperation = 'destination-out';
        ctx.beginPath();
        ctx.arc(x, y, 20, 0, Math.PI * 2);
        ctx.fill();

        checkScratchProgress();
    }

    function checkScratchProgress() {
        if (isRevealed) return;
        const imgData = ctx.getImageData(0, 0, canvas.width, canvas.height);
        let clearPixels = 0;
        const total = imgData.data.length / 4;

        for (let i = 3; i < imgData.data.length; i += 64) {
            if (imgData.data[i] === 0) clearPixels++;
        }

        const sampleTotal = total / 16;
        if (clearPixels / sampleTotal > 0.45) {
            isRevealed = true;
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            if (window.sweetSFX) window.sweetSFX.fanfare();
            if (window.triggerConfetti) {
                const rect = canvas.getBoundingClientRect();
                window.triggerConfetti(rect.left + rect.width / 2, rect.top + rect.height / 2, 60);
            }
            showSweetToast('Selamat! Hadiah kejutanmu terungkap! 🎁✨', '🎉');
        }
    }

    canvas.addEventListener('mousedown', () => isScratching = true);
    window.addEventListener('mouseup', () => isScratching = false);
    canvas.addEventListener('mousemove', scratch);

    canvas.addEventListener('touchstart', (e) => { isScratching = true; scratch(e); }, { passive: true });
    window.addEventListener('touchend', () => isScratching = false);
    canvas.addEventListener('touchmove', (e) => { scratch(e); e.preventDefault(); }, { passive: false });

    btnResetScratch.addEventListener('click', () => {
        if (window.sweetSFX) window.sweetSFX.pop();
        initScratchCanvas();
        showSweetToast('Kartu baru siap digosok! 🎫✨', '🌸');
    });

    initScratchCanvas();

    // 2. Submit Wish Form with AJAX
    const form = document.getElementById('addWishForm');
    const wishBoard = document.getElementById('wishBoard');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(form);

        try {
            const res = await fetch('/api/wishes', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': getCsrfToken()
                },
                body: formData
            });
            const data = await res.json();
            if (data.success) {
                const w = data.wish;
                const newNote = document.createElement('div');
                newNote.className = `wish-note color-${w.color}`;
                newNote.dataset.id = w.id;
                newNote.style.animation = 'jellyBounce 0.4s ease';
                newNote.innerHTML = `
                    <div class="note-pin">📌</div>
                    <div>
                        <div class="wish-author">
                            <span>${w.sticker}</span>
                            <span>${w.name}</span>
                        </div>
                        <div class="wish-text">
                            "${w.message}"
                        </div>
                    </div>
                    <div class="wish-footer">
                        <span>🕒 ${w.time}</span>
                        <button type="button" class="like-button-badge btn-like-wish" data-id="${w.id}" data-custom-sfx="true">
                            <span>💖</span> <span class="like-count">0</span>
                        </button>
                    </div>
                `;

                wishBoard.prepend(newNote);
                attachLikeWishHandler(newNote.querySelector('.btn-like-wish'));

                form.reset();
                if (window.sweetSFX) window.sweetSFX.fanfare();
                if (window.triggerConfetti) {
                    const rect = newNote.getBoundingClientRect();
                    window.triggerConfetti(rect.left + rect.width / 2, rect.top, 50);
                }
                showSweetToast('Doamu berhasil ditempelkan di papan! 💖🌸', '✨');
            }
        } catch (err) {
            console.error(err);
            showSweetToast('Gagal menempelkan doa :(', '😿');
        }
    });

    // 3. Like Wish Handler
    function attachLikeWishHandler(btn) {
        btn.addEventListener('click', async (e) => {
            e.stopPropagation();
            const id = btn.dataset.id;
            const countSpan = btn.querySelector('.like-count');

            if (window.sweetSFX) window.sweetSFX.pop();

            try {
                const res = await fetch(`/api/wishes/${id}/like`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': getCsrfToken()
                    }
                });
                const data = await res.json();
                if (data.success) {
                    countSpan.textContent = data.likes;
                    showSweetToast('Kamu mengaminkan doa ini! 💖', '🌸');
                }
            } catch (err) {
                console.error(err);
            }
        });
    }

    document.querySelectorAll('.btn-like-wish').forEach(attachLikeWishHandler);
});
</script>
@endsection
