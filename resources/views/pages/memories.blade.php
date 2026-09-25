@extends('layouts.app')

@section('content')
<div class="sweet-container">
    <header class="hero-header">
        <div class="badge-tag">
            Album Kenangan
        </div>
        <h1 class="hero-title">Foto di Galeri</h1>
        <p class="hero-subtitle">Hargai setiap momen, ling. Susah buat bebas kayak dulu lagi 😥</p>
    </header>

    <!-- Add New Memory Button -->
    <div style="display: flex; justify-content: flex-end; margin-bottom: 16px;">
        <button type="button" id="btnOpenAddMemory" class="btn-sweet-primary" style="font-size: 0.88rem; padding: 8px 18px;">
            <span>✨</span> Tambah Kenangan Baru
        </button>
    </div>

    <!-- Polaroid Grid -->
    <div class="polaroid-grid">
        @foreach ($memories as $p)
            <div class="polaroid-card" data-id="{{ $p->id }}" data-title="{{ $p->title }}" data-caption="{{ $p->caption }}" data-sticker="{{ $p->sticker }}" data-date="{{ $p->date_label }}">
                <div class="washi-tape"></div>
                <div class="polaroid-photo" style="background: {{ $p->theme_color ?? '#ffd6df' }};">
                    <span style="font-size: 4rem;">{{ $p->sticker ?? '💖' }}</span>
                </div>
                <div class="polaroid-caption">
                    "{{ $p->caption }}"
                </div>
                <div class="polaroid-footer">
                    <span class="polaroid-date">🗓️ {{ $p->date_label }}</span>
                    <button type="button" class="like-button-badge" data-id="{{ $p->id }}" data-custom-sfx="true">
                        <span>💖</span> <span class="like-count">{{ $p->likes }}</span>
                    </button>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Lightbox Modal -->
    <div class="sweet-modal-backdrop" id="polaroidLightbox">
        <div class="sweet-modal-box" style="text-align: center;">
            <button class="modal-close-btn" id="btnCloseLightbox">✕</button>
            <div id="lightboxPhoto" style="width: 110px; height: 110px; border-radius: 50%; background: var(--primary-light); margin: 0 auto 12px; display: flex; align-items: center; justify-content: center; font-size: 3.2rem; box-shadow: 0 8px 20px var(--shadow);">
                🌸
            </div>
            <h3 id="lightboxTitle" style="font-family: var(--font-heading); color: var(--accent); font-size: 1.4rem; margin-bottom: 4px;">
                Momen Indah
            </h3>
            <span id="lightboxDate" style="font-size: 0.8rem; color: var(--text-soft); font-weight: 600; display: block; margin-bottom: 12px;">
                🗓️ Tanggal Spesial
            </span>
            <p id="lightboxCaption" style="font-family: var(--font-handwriting); font-size: 1.55rem; color: #4a3b32; line-height: 1.45; margin-bottom: 20px;">
                Catatan manis kenangan.
            </p>
            <button type="button" class="btn-sweet-primary" id="btnLightboxCheer">
                <span>🎉</span> Tepuk Tangan Manis
            </button>
        </div>
    </div>

    <!-- Modal Tambah Kenangan -->
    <div class="sweet-modal-backdrop" id="addMemoryModal">
        <div class="sweet-modal-box">
            <button class="modal-close-btn" id="btnCloseAddMemory">✕</button>
            <div style="text-align: center; margin-bottom: 14px;">
                <div style="font-size: 1.8rem; margin-bottom: 2px;">📸</div>
                <h3 style="font-family: var(--font-heading); color: var(--accent); font-size: 1.35rem;">Abadikan Kenangan</h3>
                <p style="font-size: 0.82rem; color: var(--text-soft);">Tuliskan momen berharga yang tak akan pernah terlupa!</p>
            </div>

            <form method="POST" action="{{ route('memories.store') }}">
                @csrf
                <div style="margin-bottom: 10px;">
                    <label style="font-weight: 700; font-size: 0.82rem; display: block; margin-bottom: 4px;">Judul Kenangan:</label>
                    <input type="text" name="title" class="wish-input-box" placeholder="Contoh: Pertama Kali Ketemu" required>
                </div>

                <div style="margin-bottom: 10px;">
                    <label style="font-weight: 700; font-size: 0.82rem; display: block; margin-bottom: 4px;">Momen / Tanggal:</label>
                    <input type="text" name="date_label" class="wish-input-box" value="Hari Paling Manis" required>
                </div>

                <div style="margin-bottom: 10px;">
                    <label style="font-weight: 700; font-size: 0.82rem; display: block; margin-bottom: 4px;">Catatan Kenangan:</label>
                    <textarea name="caption" class="wish-input-box" rows="3" placeholder="Cerita singkat yang bikin tersenyum..." required></textarea>
                </div>

                <div style="margin-bottom: 14px; display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                    <div>
                        <label style="font-weight: 700; font-size: 0.82rem; display: block; margin-bottom: 4px;">Pilih Ikon:</label>
                        <select name="sticker" class="wish-input-box" style="cursor: pointer;">
                            <option value="🌸">🌸 Bunga</option>
                            <option value="🍓">🍓 Stroberi</option>
                            <option value="🧸">🧸 Boneka</option>
                            <option value="🎂">🎂 Kue</option>
                            <option value="✨">✨ Bintang</option>
                            <option value="🐱">🐱 Kucing</option>
                        </select>
                    </div>
                    <div>
                        <label style="font-weight: 700; font-size: 0.82rem; display: block; margin-bottom: 4px;">Warna:</label>
                        <select name="theme_color" class="wish-input-box" style="cursor: pointer;">
                            <option value="#ffd6df">Baby Pink</option>
                            <option value="#ffe5d9">Peach</option>
                            <option value="#eeddff">Lavender</option>
                            <option value="#d8f3ec">Mint</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn-sweet-primary" style="width: 100%; justify-content: center;">
                    <span>💖</span> Simpan Kenangan
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    // 1. Lightbox Open
    const lightbox = document.getElementById('polaroidLightbox');
    const closeLightbox = document.getElementById('btnCloseLightbox');
    const lbPhoto = document.getElementById('lightboxPhoto');
    const lbTitle = document.getElementById('lightboxTitle');
    const lbDate = document.getElementById('lightboxDate');
    const lbCaption = document.getElementById('lightboxCaption');
    const btnCheer = document.getElementById('btnLightboxCheer');

    document.querySelectorAll('.polaroid-card').forEach(card => {
        card.addEventListener('click', (e) => {
            if (e.target.closest('.like-button-badge')) return;

            lbPhoto.innerHTML = `<span style="font-size: 3.2rem;">${card.dataset.sticker}</span>`;
            lbTitle.textContent = card.dataset.title;
            lbDate.textContent = `🗓️ ${card.dataset.date}`;
            lbCaption.textContent = `"${card.dataset.caption}"`;

            if (window.sweetSFX) window.sweetSFX.chime();
            lightbox.style.display = 'flex';
        });
    });

    closeLightbox.addEventListener('click', () => {
        lightbox.style.display = 'none';
        if (window.sweetSFX) window.sweetSFX.pop();
    });

    lightbox.addEventListener('click', (e) => {
        if (e.target === lightbox) lightbox.style.display = 'none';
    });

    btnCheer.addEventListener('click', () => {
        if (window.sweetSFX) window.sweetSFX.fanfare();
        if (window.triggerConfetti) {
            window.triggerConfetti(window.innerWidth / 2, window.innerHeight / 2, 60);
        }
        showSweetToast('Tepuk tangan cinta untuk momen ini! 👏💖', '🌸');
    });

    // 2. Like Memory with AJAX
    document.querySelectorAll('.like-button-badge').forEach(btn => {
        btn.addEventListener('click', async (e) => {
            e.stopPropagation();
            const id = btn.dataset.id;
            const countSpan = btn.querySelector('.like-count');

            if (window.sweetSFX) window.sweetSFX.pop();

            try {
                const res = await fetch(`/api/memories/${id}/like`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': getCsrfToken()
                    }
                });
                const data = await res.json();
                if (data.success) {
                    countSpan.textContent = data.likes;
                    showSweetToast('Aww, kamu memberi cinta pada foto ini! 💖', '🌸');
                }
            } catch (err) {
                console.error(err);
            }
        });
    });

    // 3. Add Memory Modal
    const addModal = document.getElementById('addMemoryModal');
    const btnOpenAdd = document.getElementById('btnOpenAddMemory');
    const btnCloseAdd = document.getElementById('btnCloseAddMemory');

    btnOpenAdd.addEventListener('click', () => {
        if (window.sweetSFX) window.sweetSFX.boing();
        addModal.style.display = 'flex';
    });

    btnCloseAdd.addEventListener('click', () => {
        if (window.sweetSFX) window.sweetSFX.pop();
        addModal.style.display = 'none';
    });

    addModal.addEventListener('click', (e) => {
        if (e.target === addModal) addModal.style.display = 'none';
    });
});
</script>
@endsection
