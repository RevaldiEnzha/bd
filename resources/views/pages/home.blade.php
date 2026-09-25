@extends('layouts.app')

@section('content')
<div class="sweet-container">
    <!-- Hero Header -->
    <header class="hero-header">
        <div class="badge-tag">
            {{ $settings['header_badge'] ?? 'Hari Spesial' }}
        </div>
        <h1 class="hero-title">{{ $settings['title'] ?? 'Selamat Ulang Tahun!' }}</h1>
        <p class="hero-subtitle">{{ $settings['tagline'] ?? 'Semoga hari ini indah.' }}</p>
    </header>

    <!-- Main Surprise Interactive Card -->
    <div class="sweet-card" style="text-align: center;">
        <div class="gift-box-wrapper">
            <div class="interactive-gift clickable" id="mainGiftBox">
                <div class="gift-lid">
                    <span class="gift-ribbon-bow">🎀</span>
                </div>
                <div class="gift-base">
                    <div class="gift-stripe"></div>
                </div>
            </div>

            <div class="gift-instruction-badge" id="giftHint">
                Pencet kotak kado supaya kebuka! (<span id="tapCount">0</span>/3)
            </div>

            <!-- Revealed Content after 3 taps -->
            <div id="giftRevealedCard" style="display: none; margin-top: 24px; animation: jellyBounce 0.5s ease;">
                <div style="font-size: 2.8rem; margin-bottom: 6px;">🎉</div>
                <h2 style="font-family: var(--font-heading); color: var(--accent); font-size: 1.6rem; margin-bottom: 10px;">
                    GOKIL! Kado Kebuka!
                </h2>
                <p style="font-size: 1rem; color: var(--text); max-width: 520px; margin: 0 auto 18px; line-height: 1.5;">
                    Hari ini semesta raya merayakan kelahiran seseorang yang keren, yaitu: 
                    <strong style="color: var(--accent); font-size: 1.15rem;">{{ $settings['name'] }}</strong>! 
                    
                </p>
                <div style="display: flex; gap: 10px; justify-content: center; flex-wrap: wrap;">
                    <a href="{{ route('cake') }}" class="btn-sweet-primary">
                        <span>🎂</span> Tiup Lilin Sekarang!
                    </a>
                    <a href="{{ route('letter') }}" class="btn-sweet-secondary">
                        <span>💌</span> Buka Surat
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Mini Balloon Playground (Touch friendly) -->
    <div class="sweet-card" style="background: linear-gradient(135deg, rgba(255,255,255,0.95), var(--primary-light));">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; margin-bottom: 14px;">
            <div>
                <h3 style="font-family: var(--font-heading); color: var(--accent); font-size: 1.25rem;">
                    🎈 Balon Keberuntungan!
                </h3>
                <p style="font-size: 0.82rem; color: var(--text-soft);">
                    Pencet balon untuk menambah skor!
                    <br>Semakin tinggi skor, semakin ira beruntung besok👌</br>
                </p>
            </div>
            <div style="background: white; border: 2px solid var(--border); padding: 6px 14px; border-radius: 18px; font-weight: 700; color: var(--accent); font-size: 0.88rem;">
                🍀 Skor: <span id="sweetScore" style="font-size: 1.1rem;">0</span> poin
            </div>
        </div>

        <div id="balloonPlayground" style="display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; padding: 12px 0;">
            <!-- Balloons generated dynamically -->
        </div>
    </div>

    <br>

    <!-- Feature Navigation Grid -->
    <h3 style="font-family: var(--font-heading); color: var(--accent); font-size: 1.4rem; text-align: center; margin: 32px 0 16px;">
        Pilih! Mau yang Mana
    </h3>

    <div class="feature-nav-grid">
        <a href="{{ route('cake') }}" class="feature-nav-card">
            <div class="feature-icon-circle">🎂</div>
            <h4 class="feature-nav-title">Tiup Lilin Kue</h4>
            <p class="feature-nav-desc">Tulis harapan, tiup lilin sama potong kue virtual</p>
        </a>

        <a href="{{ route('letter') }}" class="feature-nav-card">
            <div class="feature-icon-circle">💌</div>
            <h4 class="feature-nav-title">Surat</h4>
            <p class="feature-nav-desc">Buka segel lilin dan baca surat!</p>
        </a>

        <a href="{{ route('memories') }}" class="feature-nav-card">
            <div class="feature-icon-circle">📸</div>
            <h4 class="feature-nav-title">Galeri Kenangan</h4>
            <p class="feature-nav-desc">Foto yang ada di galeri.</p>
        </a>

        <a href="{{ route('wishes') }}" class="feature-nav-card">
            <div class="feature-icon-circle">🌟</div>
            <h4 class="feature-nav-title">Kotak Harapan</h4>
            <p class="feature-nav-desc">Tuliskan doa di sticky notes</p>
        </a>

        <a href="{{ route('game') }}" class="feature-nav-card">
            <div class="feature-icon-circle">🎮</div>
            <h4 class="feature-nav-title">Mini Game</h4>
            <p class="feature-nav-desc">Tangkap stroberi & kado untuk memenangkan Sertifikat!</p>
        </a>
    </div>

    <!-- Daily Sweet Affirmation Box -->
    <div class="sweet-card" style="text-align: center; margin-top: 30px; border: 2px dashed var(--accent);">
        <div style="font-size: 1.8rem; margin-bottom: 4px;">✋</div>
        <h4 style="font-family: var(--font-heading); color: var(--accent); margin-bottom: 6px; font-size: 1.15rem;">
            Kata-kata Hari Ini Khusus Untuk LingLung
        </h4>
        <p id="affirmationText" style="font-family: var(--font-handwriting); font-size: 1.5rem; color: #4a3b32; min-height: 48px; line-height: 1.4;">
            "Terserah tuhan saja ingin beri jodoh orang mana, asal jangan orang Israel!"
        </p>
        <button id="btnNewAffirmation" class="btn-sweet-secondary" style="margin-top: 10px;">
            Kata-kata Lain
        </button>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    // 1. Gift Box Interaction
    const giftBox = document.getElementById('mainGiftBox');
    const giftHint = document.getElementById('giftHint');
    const tapCountSpan = document.getElementById('tapCount');
    const revealedCard = document.getElementById('giftRevealedCard');
    let taps = 0;

    giftBox.addEventListener('click', (e) => {
        if (taps >= 3) return;
        taps++;
        tapCountSpan.textContent = taps;

        giftBox.classList.remove('wiggle');
        void giftBox.offsetWidth;
        giftBox.classList.add('wiggle');

        if (taps === 1) {
            if (window.sweetSFX) window.sweetSFX.boing();
            giftHint.innerHTML = "Pencet lagi! (1/3)";
        } else if (taps === 2) {
            if (window.sweetSFX) window.sweetSFX.boing();
            giftHint.innerHTML = "Satu lagi bakal terbuka! (2/3)";
        } else if (taps >= 3) {
            giftBox.classList.add('opened');
            if (window.sweetSFX) window.sweetSFX.fanfare();
            if (window.triggerConfetti) {
                const rect = giftBox.getBoundingClientRect();
                window.triggerConfetti(rect.left + rect.width / 2, rect.top + rect.height / 2, 70);
            }
            giftHint.style.display = 'none';
            revealedCard.style.display = 'block';
        }
    });

    // 2. Balloon Playground
    const playground = document.getElementById('balloonPlayground');
    const scoreSpan = document.getElementById('sweetScore');
    let score = 0;

    const balloonMessages = [
        "Semoga besok ada yang ngasih Naufa geprek 2 kotak! 🍗",
        "Semoga hari-hari Naufa selalu semanis es krim vanilla! 🍦",
        "Semoga Naufa makin hari makin bersinar! ⭐",
        "Semoga cobaan Naufa tidak sepedas Gacoan! 🍜",
        "Semoga rezeki dan kebahagiaan berlipat ganda! 💰",
        "Naufa adalah teman terbaik! 🧸 (mungkin)"
    ];

    const colors = ['#ff8da1', '#ffb3c1', '#b388ff', '#ffc6a5', '#98f5e1', '#ffe066'];

    for (let i = 0; i < 6; i++) {
        const balloon = document.createElement('div');
        balloon.style.width = '52px';
        balloon.style.height = '66px';
        balloon.style.background = colors[i % colors.length];
        balloon.style.borderRadius = '50% 50% 50% 50% / 40% 40% 60% 60%';
        balloon.style.display = 'flex';
        balloon.style.alignItems = 'center';
        balloon.style.justifyContent = 'center';
        balloon.style.cursor = 'pointer';
        balloon.style.boxShadow = '0 4px 12px rgba(0,0,0,0.1)';
        balloon.style.transition = 'transform 0.2s ease, opacity 0.2s ease';
        balloon.innerHTML = `<span style="font-size: 1.2rem;">✨</span>`;

        balloon.addEventListener('click', (e) => {
            if (window.sweetSFX) window.sweetSFX.pop();
            score += 10;
            scoreSpan.textContent = score;

            showSweetToast(balloonMessages[i % balloonMessages.length], '🎈');

            balloon.style.transform = 'scale(0)';
            balloon.style.opacity = '0';
            setTimeout(() => {
                balloon.style.transform = 'scale(1)';
                balloon.style.opacity = '1';
            }, 3000);
        });

        playground.appendChild(balloon);
    }

    // 3. Affirmation Generator
    const affirmations = [
        "\"Beruntung banget pernah kenal sama makhluk sebaik Naufa.\" 🙊",
        "\"Bangga sama diri sendiri! soalnya orang yang namanya Naufa tuh keren.\" ✨",
        "\"Jangan lupa kalo ira tuh luar biasa.\" 💖",
        "\"Selamat bertambah tua. tambah tua tambah bijaksana, kok.\" 🙂‍↕️"
    ];

    const btnAffirmation = document.getElementById('btnNewAffirmation');
    const textAffirmation = document.getElementById('affirmationText');

    btnAffirmation.addEventListener('click', () => {
        if (window.sweetSFX) window.sweetSFX.chime();
        textAffirmation.style.opacity = 0;
        setTimeout(() => {
            const randomAff = affirmations[Math.floor(Math.random() * affirmations.length)];
            textAffirmation.textContent = randomAff;
            textAffirmation.style.opacity = 1;
        }, 150);
    });
});
</script>
@endsection
