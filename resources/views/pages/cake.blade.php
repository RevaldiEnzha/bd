@extends('layouts.app')

@section('content')
<div class="sweet-container">
    <header class="hero-header">
        <div class="badge-tag">
            Ritual Ulang Tahun <span>🎂</span>
        </div>
        <h1 class="hero-title">Kue Ulang Tahun & Tiup Lilin</h1>
        <p class="hero-subtitle">Sebelum tiup lilin, jangan lupa tulis harapan terus pejamkan mata!</p>
    </header>

    <div class="sweet-card" style="text-align: center;">
        <div class="cake-stage">
            <br><br>
            <!-- The Interactive Cake -->
            <div class="cake-container" id="cakeContainer">
                <!-- Candles Row -->
                <div class="candles-row" id="candlesRow">
                    <div class="candle" data-id="1" title="Sentuh lilin untuk meniup">
                        <div class="flame"></div>
                        <div class="candle-wick"></div>
                    </div>
                    <div class="candle" data-id="2" title="Sentuh lilin untuk meniup">
                        <div class="flame"></div>
                        <div class="candle-wick"></div>
                    </div>
                    <div class="candle" data-id="3" title="Sentuh lilin untuk meniup">
                        <div class="flame"></div>
                        <div class="candle-wick"></div>
                    </div>
                </div>

                <!-- Tier Top -->
                <div class="cake-tier tier-top">
                    <div class="strawberry-toppings">
                        <span class="strawberry">🍓</span>
                        <span class="strawberry">🍒</span>
                        <span class="strawberry">🍓</span>
                    </div>
                </div>

                <!-- Tier Bottom -->
                <div class="cake-tier tier-bottom"></div>

                <!-- Cake Plate -->
                <div class="cake-plate"></div>
            </div>

            <!-- Secret Wish Jar Input -->
            <div class="wishing-zone" id="wishZone">
                <h4 style="font-family: var(--font-heading); color: var(--accent); margin-bottom: 6px; font-size: 1.15rem;">
                    Kotak Harapan 
                </h4>
                <p style="font-size: 0.82rem; color: var(--text-soft); margin-bottom: 10px;">
                    Ketik harapan di tahun ini lalu simpan sebelum meniup lilin:
                </p>
                <input type="text" id="secretWishInput" class="wish-input-box" placeholder="Tulis harapan di sini..." maxlength="120">
                <button type="button" id="btnSaveWishJar" class="btn-sweet-secondary" style="font-size: 0.88rem; padding: 7px 18px;">
                    Simpan 
                </button>
                <div id="wishSavedStatus" style="display: none; margin-top: 8px; font-weight: 700; color: #2cb698; font-size: 0.85rem;">
                    Harapan seseorang bernama Naufa telah tersimpan aman!
                </div>
            </div>

            <!-- Cake Actions -->
            <div class="cake-actions">
                <button type="button" id="btnBlowCandles" class="btn-sweet-primary">
                    <span>💨</span> Tiup Semua Lilin!
                </button>
                <button type="button" id="btnCutCake" class="btn-sweet-secondary" style="display: none;">
                    <span>🍰</span> Potong Kue Manis
                </button>
                <button type="button" id="btnRelight" class="btn-sweet-secondary" style="display: none;">
                    <span>🕯️</span> Nyalakan Lilin Lagi
                </button>
            </div>

            <!-- Celebration Banner after blowing -->
            <div id="celebrationBanner" style="display: none; margin-top: 20px; animation: jellyBounce 0.5s ease;">
                <div style="font-size: 2.2rem; margin-bottom: 4px;">🥳🎉</div>
                <h3 style="font-family: var(--font-heading); color: var(--accent); font-size: 1.45rem; margin-bottom: 6px;">
                    MANTAPP! LILIN PADAM!
                </h3>
                <p style="font-size: 0.95rem; color: var(--text); max-width: 480px; margin: 0 auto; line-height: 1.5;">
                    Semua doa dan harapan indah Naufa telah didengar dan diaminkan semesta!
                </p>
            </div>

            <!-- Cake Slice Reveal -->
            <div class="slice-reveal-card" id="sliceReveal">
                <div style="font-size: 3.5rem; margin-bottom: 8px; animation: gentleWobble 2s infinite;">🍰</div>
                <h4 style="font-family: var(--font-heading); color: var(--accent); font-size: 1.25rem; margin-bottom: 6px;">
                    Sepotong Kue untuk {{ $settings['nickname'] ?? 'Kamu' }}!
                </h4>
                <p style="font-size: 0.92rem; color: var(--text); max-width: 440px; margin: 0 auto; line-height: 1.5;">
                    "Kue stroberi manis ini dibuat dengan <strong>100% Kebahagiaan</strong> dan 
                    <strong>0% Rasa Sedih</strong>. Semoga kebahagiaan itu bakal ada menemani Naufa selama tahun ini!"
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const candles = document.querySelectorAll('.candle');
    const btnBlow = document.getElementById('btnBlowCandles');
    const btnCut = document.getElementById('btnCutCake');
    const btnRelight = document.getElementById('btnRelight');
    const banner = document.getElementById('celebrationBanner');
    const sliceCard = document.getElementById('sliceReveal');
    const btnSaveWish = document.getElementById('btnSaveWishJar');
    const wishInput = document.getElementById('secretWishInput');
    const wishStatus = document.getElementById('wishSavedStatus');

    let blownCount = 0;

    candles.forEach(candle => {
        candle.addEventListener('click', (e) => {
            if (candle.classList.contains('blown')) return;
            blowCandle(candle);
        });
    });

    function blowCandle(candle) {
        candle.classList.add('blown');
        const smoke = document.createElement('div');
        smoke.className = 'smoke';
        candle.appendChild(smoke);

        if (window.sweetSFX) window.sweetSFX.blow();

        blownCount++;
        if (blownCount === candles.length) {
            allCandlesBlown();
        }
    }

    function allCandlesBlown() {
        if (window.sweetSFX) window.sweetSFX.fanfare();
        if (window.triggerConfetti) {
            window.triggerConfetti(window.innerWidth / 2, window.innerHeight / 2, 70);
        }

        btnBlow.style.display = 'none';
        btnCut.style.display = 'inline-flex';
        btnRelight.style.display = 'inline-flex';
        banner.style.display = 'block';

        showSweetToast('YEY! HAPPY BIRTHDAY!🥳');
    }

    btnBlow.addEventListener('click', () => {
        candles.forEach((candle, idx) => {
            setTimeout(() => {
                if (!candle.classList.contains('blown')) {
                    blowCandle(candle);
                }
            }, idx * 160);
        });
    });

    btnRelight.addEventListener('click', () => {
        candles.forEach(candle => {
            candle.classList.remove('blown');
            const smoke = candle.querySelector('.smoke');
            if (smoke) smoke.remove();
        });
        blownCount = 0;
        banner.style.display = 'none';
        sliceCard.style.display = 'none';
        btnBlow.style.display = 'inline-flex';
        btnCut.style.display = 'none';
        btnRelight.style.display = 'none';
        if (window.sweetSFX) window.sweetSFX.chime();
        showSweetToast('Lilin dinyalakan kembali!');
    });

    btnCut.addEventListener('click', () => {
        if (window.sweetSFX) window.sweetSFX.chime();
        sliceCard.style.display = 'block';
        sliceCard.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        if (window.triggerConfetti) {
            const rect = sliceCard.getBoundingClientRect();
            window.triggerConfetti(rect.left + rect.width / 2, rect.top, 50);
        }
        showSweetToast('Nyam! Kuenya manis loh! 🍰', '🍓');
    });

    btnSaveWish.addEventListener('click', () => {
        const val = wishInput.value.trim();
        if (!val) {
            showSweetToast('Tulis harapan dulu woii!');
            return;
        }

        if (window.sweetSFX) window.sweetSFX.chime();
        wishStatus.style.display = 'block';
        showSweetToast('Harapan rahasiamu berhasil dikunci ke dalam botol! 🫙✨', '🌟');
        wishInput.disabled = true;
        btnSaveWish.disabled = true;
        btnSaveWish.style.opacity = '0.6';
    });
});
</script>
@endsection
