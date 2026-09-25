/**
 * Sweet Birthday - Main JavaScript with Laravel CSRF Integration
 */

document.addEventListener('DOMContentLoaded', () => {
    initSettingsModal();
    initAudioControls();
    initGlobalConfettiButton();
});

function getCsrfToken() {
    const meta = document.querySelector('meta[name="csrf-token"]');
    return meta ? meta.getAttribute('content') : '';
}

/* Settings Modal Handling */
function initSettingsModal() {
    const modal = document.getElementById('settingsModal');
    const openBtn = document.getElementById('btnSettingsModal');
    const closeBtn = document.getElementById('btnCloseSettings');
    const form = document.getElementById('settingsForm');

    if (!modal) return;

    if (openBtn) {
        openBtn.addEventListener('click', () => {
            if (window.sweetSFX) window.sweetSFX.boing();
            modal.style.display = 'flex';
        });
    }

    if (closeBtn) {
        closeBtn.addEventListener('click', () => {
            if (window.sweetSFX) window.sweetSFX.pop();
            modal.style.display = 'none';
        });
    }

    window.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    });

    if (form) {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(form);

            try {
                const res = await fetch('/api/settings', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': getCsrfToken()
                    },
                    body: formData
                });
                const data = await res.json();
                if (data.success) {
                    if (window.sweetSFX) window.sweetSFX.fanfare();
                    if (window.triggerConfetti) window.triggerConfetti();
                    showSweetToast('Pengaturan manis tersimpan! 🌸', '✨');
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                }
            } catch (err) {
                console.error(err);
                showSweetToast('Gagal menyimpan pengaturan :(', '😿');
            }
        });
    }
}

/* Audio & Music Controls */
function initAudioControls() {
    const btnAudio = document.getElementById('btnToggleAudio');
    const audioIcon = document.getElementById('audioIcon');
    const audioText = document.getElementById('audioStatusText');
    const btnMusic = document.getElementById('btnToggleMusicNav');

    if (window.sweetSFX) {
        updateAudioUI(window.sweetSFX.soundEnabled);
    }

    if (btnAudio) {
        btnAudio.addEventListener('click', () => {
            if (!window.sweetSFX) return;
            const state = window.sweetSFX.toggleSound();
            updateAudioUI(state);
            showSweetToast(state ? 'Efek Suara Aktif! 🔊' : 'Efek Suara Senyap 🔇', state ? '🎶' : '🤫');
        });
    }

    if (btnMusic) {
        btnMusic.addEventListener('click', () => {
            if (!window.sweetSFX) return;
            const isPlaying = window.sweetSFX.toggleMusic();
            btnMusic.style.transform = isPlaying ? 'scale(1.15)' : 'scale(1)';
            btnMusic.style.background = isPlaying ? 'var(--primary-light)' : 'white';
            showSweetToast(isPlaying ? 'Memutar Musik Manis! 🎵' : 'Musik Dijeda ⏸️', '🎶');
        });
    }

    function updateAudioUI(enabled) {
        if (audioIcon) audioIcon.textContent = enabled ? '🔊' : '🔇';
        if (audioText) audioText.textContent = enabled ? 'ON' : 'OFF';
    }
}

/* Confetti Button */
function initGlobalConfettiButton() {
    const btn = document.getElementById('btnBurstConfetti');
    if (!btn) return;

    btn.addEventListener('click', (e) => {
        const rect = btn.getBoundingClientRect();
        if (window.triggerConfetti) {
            window.triggerConfetti(rect.left + rect.width / 2, rect.top, 70);
        }
        showSweetToast('Yay! Hujan konfeti manis! 🎉', '💖');
    });
}
