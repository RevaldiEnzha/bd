@extends('layouts.app')

@section('content')
<div class="sweet-container">
    <header class="hero-header">
        <div class="badge-tag">
            Pesan 
        </div>
        <h1 class="hero-title">Surat Spesial Buat "Naufa Aulia"</h1>
        <p class="hero-subtitle">Ada surat nih...</p>
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
                    <button type="button" id="btnDownloadLetter" class="btn-sweet-secondary">
                        Download Surat (siapa tau butuh🙄)
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const waxSeal = document.getElementById('waxSeal');
    const sealedEnvelope = document.getElementById('sealedEnvelope');
    const parchmentLetter = document.getElementById('parchmentLetter');
    const envelopeHint = document.getElementById('envelopeHint');
    const stampSection = document.getElementById('stampSection');
    const typewriterTarget = document.getElementById('typewriterTarget');
    const btnDownloadLetter = document.getElementById('btnDownloadLetter');
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
            showSweetToast('Surat terbuka!');
        }, 450);
    });

    function typewriterEffect(text, element) {
        let index = 0;
        element.textContent = '';

        btnDownloadLetter.disabled = true;
        btnDownloadLetter.style.opacity = '0.5';

        function type() {
            if (index < text.length) {
                element.textContent += text.charAt(index);
                index++;

                if (index % 4 === 0 && window.sweetSFX) {
                    window.sweetSFX.typeTick();
                }

                setTimeout(type, 16);
            } else {
                // Surat selesai diketik
                btnDownloadLetter.disabled = false;
                btnDownloadLetter.style.opacity = '1';
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
        const x = ((clientX - rect.left) / rect.width) * 100;
        const y = ((clientY - rect.top) / rect.height) * 100;

        const sticker = document.createElement('span');
        sticker.className = 'placed-sticker';
        sticker.textContent = selectedStamp;
        sticker.style.left = `${x}%`;
        sticker.style.top = `${y}%`;

        parchmentLetter.appendChild(sticker);
        if (window.sweetSFX) window.sweetSFX.pop();
    });

    btnDownloadLetter.addEventListener('click', async () => {
        if (typeof html2canvas === 'undefined' || typeof window.jspdf === 'undefined') {
            showSweetToast('Library PDF belum berhasil dimuat.');
            return;
        }

        if (window.sweetSFX) {
            window.sweetSFX.chime();
        }

        const letter = document.getElementById('parchmentLetter');
        let clone = null;

        try {
            showSweetToast('Menyiapkan surat...');

            // Buat salinan surat agar tampilan asli tidak berubah
            clone = letter.cloneNode(true);

            // Atur posisi clone supaya tidak mempengaruhi halaman asli
            clone.style.position = 'absolute';
            clone.style.left = '-100000px';
            clone.style.top = '0';
            clone.style.display = 'block';
            clone.style.width = `${letter.offsetWidth}px`;
            clone.style.height = 'auto';
            clone.style.maxHeight = 'none';
            clone.style.overflow = 'visible';

            // Hilangkan animasi stiker pada hasil PDF
            clone.querySelectorAll('.placed-sticker').forEach(sticker => {
                sticker.style.animation = 'none';
            });

            document.body.appendChild(clone);

            // Beri browser waktu untuk menyelesaikan layout
            await new Promise(resolve => setTimeout(resolve, 100));

            // Render surat menjadi gambar
            const canvas = await html2canvas(clone, {
                scale: 2,
                useCORS: true,
                backgroundColor: '#fffdfa',
                logging: false,
                width: clone.scrollWidth,
                height: clone.scrollHeight,
                windowWidth: clone.scrollWidth,
                windowHeight: clone.scrollHeight
            });

            // Hapus clone setelah selesai
            document.body.removeChild(clone);
            clone = null;

            const { jsPDF } = window.jspdf;

            const pdf = new jsPDF({
                orientation: 'portrait',
                unit: 'mm',
                format: 'a4'
            });

            // Ukuran A4
            const pageWidth = 210;
            const pageHeight = 297;

            // Margin kiri/kanan
            const marginX = 10;

            // Lebar surat dalam PDF
            const pdfWidth = pageWidth - (marginX * 2);

            // Tinggi gambar berdasarkan rasio asli
            const pdfHeight = (canvas.height * pdfWidth) / canvas.width;

            // Tinggi area yang tersedia pada setiap halaman
            const usableHeight = pageHeight - 20;

            let remainingHeight = pdfHeight;
            let sourceY = 0;
            let pageNumber = 0;

            while (remainingHeight > 0) {
                if (pageNumber > 0) {
                    pdf.addPage();
                }

                const currentHeight = Math.min(
                    usableHeight,
                    remainingHeight
                );

                const sourceHeight =
                    (currentHeight / pdfHeight) * canvas.height;

                const pageCanvas = document.createElement('canvas');

                pageCanvas.width = canvas.width;
                pageCanvas.height = Math.ceil(sourceHeight);

                const pageContext = pageCanvas.getContext('2d');

                pageContext.fillStyle = '#fffdfa';
                pageContext.fillRect(
                    0,
                    0,
                    pageCanvas.width,
                    pageCanvas.height
                );

                pageContext.drawImage(
                    canvas,
                    0,
                    sourceY,
                    canvas.width,
                    sourceHeight,
                    0,
                    0,
                    canvas.width,
                    sourceHeight
                );

                const pageImage =
                    pageCanvas.toDataURL('image/jpeg', 0.98);

                pdf.addImage(
                    pageImage,
                    'JPEG',
                    marginX,
                    10,
                    pdfWidth,
                    currentHeight
                );

                sourceY += sourceHeight;
                remainingHeight -= currentHeight;
                pageNumber++;
            }

            pdf.save('surat-spesial.pdf');

            showSweetToast(
                'Surat berhasil didownload!',
            );

        } catch (error) {
            console.error('PDF Error:', error);

            if (clone && document.body.contains(clone)) {
                document.body.removeChild(clone);
            }

            showSweetToast(
                'Gagal bikin PDF surat. Coba lagi!'
            );
        }
    });
});
</script>
@endsection
