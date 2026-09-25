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
            <span>+</span> Tambah Kenangan Baru
        </button>
    </div>
    <br>

    <!-- Polaroid Grid -->
    <div class="polaroid-grid">
        @foreach ($memories as $p)
            <div
                class="polaroid-card"
                data-id="{{ $p->id }}"
                data-title="{{ $p->title }}"
                data-caption="{{ $p->caption }}"
                data-image="{{ asset('storage/' . $p->image) }}"
                data-date="{{ $p->date_label }}"
            >
                <div class="washi-tape"></div>

                <div class="polaroid-photo">
                    <img
                        src="{{ asset('storage/' . $p->image) }}"
                        alt="{{ $p->title }}"
                        class="memory-image"
                    >
                </div>

                <div class="polaroid-caption">
                    "{{ $p->caption }}"
                </div>

                <div class="polaroid-footer">
                    <span class="polaroid-date">
                        🗓️ {{ $p->date_label }}
                    </span>

                    <button
                        type="button"
                        class="like-button-badge"
                        data-id="{{ $p->id }}"
                        data-custom-sfx="true"
                    >
                        <span>💖</span>
                        <span class="like-count">{{ $p->likes }}</span>
                    </button>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Lightbox Modal -->
    <div class="sweet-modal-backdrop" id="polaroidLightbox">
        <div class="sweet-modal-box" style="text-align: center;">
            <button class="modal-close-btn" id="btnCloseLightbox">✕</button>
            <div id="lightboxPhoto" class="lightbox-photo">
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
        </div>
    </div>

    <!-- Modal Tambah Kenangan -->
    <div class="sweet-modal-backdrop" id="addMemoryModal">
        <div class="sweet-modal-box">
            <button class="modal-close-btn" id="btnCloseAddMemory">✕</button>
            <div style="text-align: center; margin-bottom: 14px;">
                <h3 style="font-family: var(--font-heading); color: var(--accent); font-size: 1.35rem;">Abadikan Kenangan</h3>
                <br>
            </div>

            <form
                method="POST"
                action="{{ route('memories.store') }}"
                enctype="multipart/form-data"
            >
                @csrf

                <div style="margin-bottom: 10px;">
                    <label style="font-weight: 700; font-size: 0.82rem; display: block; margin-bottom: 4px;">
                        Judul Kenangan:
                    </label>

                    <input
                        type="text"
                        name="title"
                        class="wish-input-box"
                        placeholder="Contoh: Kerja Kelompok"
                        required
                    >
                </div>

                <div style="margin-bottom: 10px;">
                    <label style="font-weight: 700; font-size: 0.82rem; display: block; margin-bottom: 4px;">
                        Momen / Tanggal:
                    </label>

                    <input
                        type="text"
                        name="date_label"
                        class="wish-input-box"
                        placeholder="..."
                        required
                    >
                </div>

                <div style="margin-bottom: 10px;">
                    <label style="font-weight: 700; font-size: 0.82rem; display: block; margin-bottom: 4px;">
                        Catatan Kenangan:
                    </label>

                    <textarea
                        name="caption"
                        class="wish-input-box"
                        rows="3"
                        placeholder="Cerita singkat..."
                        required
                    ></textarea>
                </div>

                <div style="margin-bottom: 14px;">
                    <label style="font-weight: 700; font-size: 0.82rem; display: block; margin-bottom: 4px;">
                        Foto Kenangan:
                    </label>

                    <input
                        type="file"
                        name="image"
                        class="wish-input-box"
                        accept="image/jpeg,image/png,image/webp"
                        required
                    >

                    <small style="display: block; margin-top: 5px; color: var(--text-soft);">
                        JPG, PNG, atau WEBP. Maksimal 5 MB.
                    </small>
                </div>

                <button
                    type="submit"
                    class="btn-sweet-primary"
                    style="width: 100%; justify-content: center;"
                >
                    Simpan Kenangan
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

    document.querySelectorAll('.polaroid-card').forEach(card => {
        card.addEventListener('click', (e) => {
            if (e.target.closest('.like-button-badge')) return;

            lbPhoto.innerHTML = `
                <img
                    src="${card.dataset.image}"
                    alt="${card.dataset.title}"
                    class="lightbox-memory-image"
                >
            `;

            lbTitle.textContent = card.dataset.title;
            lbDate.textContent = `🗓️ ${card.dataset.date}`;
            lbCaption.textContent = `"${card.dataset.caption}"`;

            if (window.sweetSFX) {
                window.sweetSFX.chime();
            }

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
