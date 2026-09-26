/**
 * Sweet Birthday - Main JavaScript with Laravel CSRF Integration
 */

document.addEventListener('DOMContentLoaded', () => {
    initSettingsModal();
    initAudioControls();
});

function getCsrfToken() {
    const meta = document.querySelector('meta[name="csrf-token"]');
    return meta ? meta.getAttribute('content') : '';
}


/* ============================================================
   SETTINGS MODAL & THEME PICKER
   ============================================================ */

function initSettingsModal() {
    const modal = document.getElementById('settingsModal');
    const openBtn = document.getElementById('btnSettingsModal');
    const closeBtn = document.getElementById('btnCloseSettings');
    const form = document.getElementById('settingsForm');
    const themeOptions = document.querySelectorAll('.theme-option');

    if (!modal) return;


    // --------------------------------------------------------
    // Open Modal
    // --------------------------------------------------------

    if (openBtn) {
        openBtn.addEventListener('click', () => {
            if (window.sweetSFX) {
                window.sweetSFX.boing();
            }

            modal.style.display = 'flex';
        });
    }


    // --------------------------------------------------------
    // Close Modal
    // --------------------------------------------------------

    if (closeBtn) {
        closeBtn.addEventListener('click', () => {
            if (window.sweetSFX) {
                window.sweetSFX.pop();
            }

            modal.style.display = 'none';
        });
    }


    // Klik area luar modal untuk menutup
    window.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    });


    // --------------------------------------------------------
    // Theme Picker
    // --------------------------------------------------------

    themeOptions.forEach(option => {
        option.addEventListener('click', () => {

            // Hapus status selected dari semua tema
            themeOptions.forEach(item => {
                item.classList.remove('selected');
            });

            // Tandai tema yang dipilih
            option.classList.add('selected');

            // Centang radio button
            const radio = option.querySelector(
                'input[type="radio"]'
            );

            if (radio) {
                radio.checked = true;
            }

            // Efek suara kecil
            if (window.sweetSFX) {
                window.sweetSFX.pop();
            }
        });
    });


    // --------------------------------------------------------
    // Submit Theme
    // --------------------------------------------------------

    if (form) {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            const formData = new FormData(form);

            try {

                const res = await fetch('/api/settings', {
                    method: 'POST',

                    headers: {
                        'X-CSRF-TOKEN': getCsrfToken(),
                        'Accept': 'application/json'
                    },

                    body: formData
                });


                // Cek response HTTP
                if (!res.ok) {
                    throw new Error(
                        `HTTP error ${res.status}`
                    );
                }


                const data = await res.json();


                if (data.success) {

                    if (window.sweetSFX) {
                        window.sweetSFX.fanfare();
                    }

                    if (window.triggerConfetti) {
                        window.triggerConfetti();
                    }

                    showSweetToast(
                        'Tema dipasang! ',
                    );


                    // Beri waktu toast terlihat
                    setTimeout(() => {
                        window.location.reload();
                    }, 900);

                } else {

                    showSweetToast(
                        'Tema gagal disimpan :(',
                        '😿'
                    );
                }

            } catch (err) {

                console.error(
                    'Gagal menyimpan tema:',
                    err
                );

                showSweetToast(
                    'Gagal menyimpan tema :(',
                    '😿'
                );
            }
        });
    }
}


/* ============================================================
   AUDIO & MUSIC CONTROLS
   ============================================================ */

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

            showSweetToast(
                state
                    ? 'Efek Suara Aktif! 🔊'
                    : 'Efek Suara Senyap 🔇',
                state ? '🎶' : '🤫'
            );
        });
    }

    if (btnMusic) {
        btnMusic.addEventListener('click', () => {

            if (!window.sweetSFX) return;

            const isPlaying =
                window.sweetSFX.toggleMusic();

            btnMusic.style.transform =
                isPlaying
                    ? 'scale(1.15)'
                    : 'scale(1)';

            btnMusic.style.background =
                isPlaying
                    ? 'var(--primary-light)'
                    : 'white';

            showSweetToast(
                isPlaying
                    ? 'Memutar Musik Manis! 🎵'
                    : 'Musik Dijeda ⏸️',
                '🎶'
            );
        });
    }

    function updateAudioUI(enabled) {
        if (audioIcon) {
            audioIcon.textContent =
                enabled ? '🔊' : '🔇';
        }

        if (audioText) {
            audioText.textContent =
                enabled ? 'ON' : 'OFF';
        }
    }
}


/* ============================================================
   GLOBAL CONFETTI BUTTON
   ============================================================ */
