/**
 * Sweet Effects - Visual particles, confetti, and touch interactions
 * NOTE: Mousemove cursor trail has been completely removed per user request!
 */

document.addEventListener('DOMContentLoaded', () => {
    initClickSparkles();
    initSoundInteractions();
});

/* ============================================================
   1. CLICK & TAP SPARKLES (Only bursts on actual click / tap!)
   ============================================================ */
function initClickSparkles() {
    window.addEventListener('pointerdown', (e) => {
        // Only spawn on interactive elements or buttons
        if (e.target.closest('button, a, .clickable, .interactive-gift, .candle, .polaroid-card, .wish-note')) {
            createClickBurst(e.clientX, e.clientY);
        }
    });
}

function createClickBurst(x, y) {
    if (!x || !y) return;
    const icons = ['✨', '💖', '⭐', '🌸'];
    const count = 5;

    for (let i = 0; i < count; i++) {
        const el = document.createElement('span');
        el.className = 'click-burst-item';
        el.textContent = icons[Math.floor(Math.random() * icons.length)];
        el.style.left = `${x}px`;
        el.style.top = `${y}px`;

        const angle = (i / count) * 2 * Math.PI;
        const dist = 28 + Math.random() * 25;
        const dx = Math.cos(angle) * dist;
        const dy = Math.sin(angle) * dist;

        el.style.setProperty('--dx', `${dx}px`);
        el.style.setProperty('--dy', `${dy}px`);

        document.body.appendChild(el);
        setTimeout(() => el.remove(), 600);
    }
}

/* ============================================================
   2. SOUND INTERACTIONS ON BUTTONS / CARDS
   ============================================================ */
function initSoundInteractions() {
    document.querySelectorAll('button, a, .clickable, .polaroid-card, .wish-note, .candle').forEach(el => {
        el.addEventListener('click', () => {
            if (window.sweetSFX && !el.dataset.customSfx) {
                window.sweetSFX.pop();
            }
        });
    });
}

/* ============================================================
   3. FULL-SCREEN CONFETTI CANNON
   ============================================================ */
window.triggerConfetti = function(originX = window.innerWidth / 2, originY = window.innerHeight / 2, count = 60) {
    if (window.sweetSFX) {
        window.sweetSFX.chime();
    }

    const canvas = document.getElementById('confettiCanvas') || createConfettiCanvas();
    const ctx = canvas.getContext('2d');
    const colors = ['#ff6b8b', '#ff9ebb', '#ffd166', '#06d6a0', '#118ab2', '#b388ff', '#ffb5a7', '#fff'];
    const shapes = ['circle', 'rect'];

    const particles = [];
    for (let i = 0; i < count; i++) {
        const angle = Math.random() * Math.PI * 2;
        const speed = Math.random() * 10 + 3;
        particles.push({
            x: originX,
            y: originY,
            vx: Math.cos(angle) * speed,
            vy: Math.sin(angle) * speed - 5,
            color: colors[Math.floor(Math.random() * colors.length)],
            shape: shapes[Math.floor(Math.random() * shapes.length)],
            size: Math.random() * 7 + 5,
            rotation: Math.random() * 360,
            rotationSpeed: (Math.random() - 0.5) * 10,
            gravity: 0.25,
            friction: 0.98,
            alpha: 1,
            decay: Math.random() * 0.018 + 0.012
        });
    }

    let animationId;
    function render() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        let alive = false;

        particles.forEach(p => {
            if (p.alpha <= 0) return;
            alive = true;

            p.vx *= p.friction;
            p.vy += p.gravity;
            p.x += p.vx;
            p.y += p.vy;
            p.rotation += p.rotationSpeed;
            p.alpha -= p.decay;

            ctx.save();
            ctx.globalAlpha = Math.max(0, p.alpha);
            ctx.translate(p.x, p.y);
            ctx.rotate((p.rotation * Math.PI) / 180);
            ctx.fillStyle = p.color;

            if (p.shape === 'circle') {
                ctx.beginPath();
                ctx.arc(0, 0, p.size / 2, 0, Math.PI * 2);
                ctx.fill();
            } else {
                ctx.fillRect(-p.size / 2, -p.size / 4, p.size, p.size / 2);
            }

            ctx.restore();
        });

        if (alive) {
            animationId = requestAnimationFrame(render);
        } else {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            cancelAnimationFrame(animationId);
        }
    }

    render();
};

function createConfettiCanvas() {
    const canvas = document.createElement('canvas');
    canvas.id = 'confettiCanvas';
    canvas.style.position = 'fixed';
    canvas.style.top = '0';
    canvas.style.left = '0';
    canvas.style.width = '100vw';
    canvas.style.height = '100vh';
    canvas.style.pointerEvents = 'none';
    canvas.style.zIndex = '999999';
    document.body.appendChild(canvas);

    const resize = () => {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
    };
    resize();
    window.addEventListener('resize', resize);
    return canvas;
}

/* ============================================================
   4. SWEET TOAST NOTIFICATION
   ============================================================ */
window.showSweetToast = function(message, icon = '') {
    const existing = document.querySelector('.sweet-toast');
    if (existing) existing.remove();

    const toast = document.createElement('div');
    toast.className = 'sweet-toast';
    toast.innerHTML = `
        <span style="font-size: 1.2rem;">${icon}</span>
        <span>${message}</span>
    `;

    document.body.appendChild(toast);

    setTimeout(() => {
        toast.classList.add('hide');
        setTimeout(() => toast.remove(), 350);
    }, 2800);
};
