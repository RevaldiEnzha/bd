@extends('layouts.app')

@section('content')
<div class="sweet-container">
    <header class="hero-header">
        <div class="badge-tag">
            Pesan 
        </div>
        <h1 class="hero-title">Surat Spesial Buat "Naufa Aulia"</h1>
        <p class="hero-subtitle">Ada amplop surat yang nunggu dibuka nih...</p>
    </header>

    <div class="sweet-card" style="text-align: center;">
        <div class="letter-stage">
            <!-- Sealed Envelope Stage -->
            <div class="envelope-wrapper" id="envelopeWrapper">
                <div class="envelope" id="sealedEnvelope">
                    <div class="envelope-ribbon"></div>
                    <div class="wax-seal" id="waxSeal" title="Sentuh untuk membuka surat!">
                        💌
                    </div>
                </div>

                <!-- Unfolded Letter Paper -->
                <div class="parchment-letter" id="parchmentLetter">
                    <div class="letter-header">
                        {{ $settings['letter_greeting'] ?? 'Hai orang favoritku,' }}
                    </div>

                    <div class="letter-content-text" id="typewriterTarget">
                        <!-- Typewriter text inserted here -->
                    </div>

                    <div class="letter-footer">
                        {{ $settings['letter_sender'] ?? 'Dengan segenap cinta 💖' }}
                    </div>

                    <div style="margin-top: 20px; font-family: var(--font-handwriting); font-size: 1.25rem; color: #7f6a5d; font-style: italic;">
                        {{ $settings['letter_postscript'] ?? '' }}
                    </div>
                </div>
            </div>

            <!-- Envelope Hint -->
            <div id="envelopeHint" class="gift-instruction-badge" style="margin-top: 16px;">
                Sentuh segel merah untuk membuka surat!
            </div>

            <!-- Sticker Stamp Palette -->
            <div id="stampSection" style="display: none; width: 100%; margin-top: 18px;">
                <p style="font-size: 0.88rem; font-weight: 700; color: var(--accent); margin-bottom: 6px;">
                    🎨 Hias Surat Ini: Pilih stiker lalu sentuh bagian mana saja pada surat!
                </p>
                <div class="stamp-toolbar">
                    <button class="stamp-btn active" data-stamp="💖">💖</button>
                    <button class="stamp-btn" data-stamp="🌸">🌸</button>
                    <button class="stamp-btn" data-stamp="🍓">🍓</button>
                    <button class="stamp-btn" data-stamp="🧸">🧸</button>
                    <button class="stamp-btn" data-stamp="🎀">🎀</button>
                    <button class="stamp-btn" data-stamp="✨">✨</button>
                    <button class="stamp-btn" data-stamp="🍰">🍰</button>
                    <button class="stamp-btn" data-stamp="💌">💌</button>
                </div>

                <div style="display: flex; gap: 10px; justify-content: center; margin-top: 16px; flex-wrap: wrap;">
                    <button type="button" class="btn-sweet-secondary" onclick="window.print()">
                        <span>🖨️</span> Cetak / Simpan Surat
                    </button>
                    <a href="{{ route('memories') }}" class="btn-sweet-primary">
                        <span>📸</span> Lanjut ke Galeri Foto
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const waxSeal = document.getElementById('waxSeal');
    const sealedEnvelope = document.getElementById('sealedEnvelope');
    const parchmentLetter = document.getElementById('parchmentLetter');
    const envelopeHint = document.getElementById('envelopeHint');
    const stampSection = document.getElementById('stampSection');
    const typewriterTarget = document.getElementById('typewriterTarget');
    const fullText = @json($processedLetterBody);

    let selectedStamp = '💖';
    let isOpened = false;

    waxSeal.addEventListener('click', (e) => {
        if (isOpened) return;
        isOpened = true;

        if (window.sweetSFX) window.sweetSFX.boing();

        waxSeal.style.transform = 'scale(1.3) rotate(35deg)';
        waxSeal.style.opacity = '0';

        setTimeout(() => {
            sealedEnvelope.style.display = 'none';
            envelopeHint.style.display = 'none';
            parchmentLetter.style.display = 'block';
            stampSection.style.display = 'block';

            if (window.sweetSFX) window.sweetSFX.fanfare();
            if (window.triggerConfetti) {
                const rect = parchmentLetter.getBoundingClientRect();
                window.triggerConfetti(rect.left + rect.width / 2, rect.top, 60);
            }

            typewriterEffect(fullText, typewriterTarget);
            showSweetToast('Surat manis terbuka untukmu! 💌✨', '🌸');
        }, 450);
    });

    function typewriterEffect(text, element) {
        let index = 0;
        element.textContent = '';

        function type() {
            if (index < text.length) {
                element.textContent += text.charAt(index);
                index++;
                if (index % 4 === 0 && window.sweetSFX) {
                    window.sweetSFX.typeTick();
                }
                setTimeout(type, 16);
            }
        }
        type();
    }

    const stampBtns = document.querySelectorAll('.stamp-btn');
    stampBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            stampBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            selectedStamp = btn.dataset.stamp;
            if (window.sweetSFX) window.sweetSFX.blip();
        });
    });

    parchmentLetter.addEventListener('click', (e) => {
        const rect = parchmentLetter.getBoundingClientRect();
        const clientX = e.clientX || (e.touches && e.touches[0].clientX);
        const clientY = e.clientY || (e.touches && e.touches[0].clientY);
        const x = clientX - rect.left - 14;
        const y = clientY - rect.top - 14;

        const sticker = document.createElement('span');
        sticker.className = 'placed-sticker';
        sticker.textContent = selectedStamp;
        sticker.style.left = `${x}px`;
        sticker.style.top = `${y}px`;

        parchmentLetter.appendChild(sticker);
        if (window.sweetSFX) window.sweetSFX.pop();
    });
});
</script>
@endsection
