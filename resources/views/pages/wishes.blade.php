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

    
    <!-- Add Wish Section -->
    <div class="sweet-card" style="margin-top: 24px;">
        <div style="text-align: center; margin-bottom: 18px;">
            <div style="font-size: 2rem; margin-bottom: 2px;">✍️💌</div>
            <h3 style="font-family: var(--font-heading); color: var(--accent); font-size: 1.4rem;">
                Tulis Apa Aja Disini
            </h3>
            <br><br>
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
                Tempel
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
                    'X-CSRF-TOKEN': getCsrfToken(),
                    'Accept': 'application/json'
                },
                body: formData
            });

            const data = await res.json();

            if (!res.ok) {
                console.error('Server error:', data);
                throw new Error(data.message || 'Request gagal');
            }

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

                        <button
                            type="button"
                            class="like-button-badge btn-like-wish"
                            data-id="${w.id}"
                            data-custom-sfx="true"
                        >
                            <span>💖</span>
                            <span class="like-count">0</span>
                        </button>
                    </div>
                `;

                wishBoard.prepend(newNote);

                attachLikeWishHandler(
                    newNote.querySelector('.btn-like-wish')
                );

                form.reset();

                if (window.sweetSFX) {
                    window.sweetSFX.fanfare();
                }

                if (window.triggerConfetti) {
                    const rect = newNote.getBoundingClientRect();

                    window.triggerConfetti(
                        rect.left + rect.width / 2,
                        rect.top,
                        50
                    );
                }

                showSweetToast(
                    'Ditempel!'
                );
            }

        } catch (err) {
            console.error('Gagal menambahkan wish:', err);

            showSweetToast(
                'Gagal :('
            );
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
                    showSweetToast('Suka!');
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
