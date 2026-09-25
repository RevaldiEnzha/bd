/**
 * SweetSFX - Procedural Web Audio Sound Effects & Background Melody
 * 100% Offline, Touch-friendly, Zero External Dependencies!
 */

class SweetSoundEngine {
    constructor() {
        this.ctx = null;
        this.soundEnabled = localStorage.getItem('sweet_sfx') !== 'false';
        this.musicEnabled = localStorage.getItem('sweet_music') === 'true';
        this.isMusicPlaying = false;
        this.musicInterval = null;
        this.initUnlockEvents();
    }

    initContext() {
        if (!this.ctx) {
            const AudioContext = window.AudioContext || window.webkitAudioContext;
            if (AudioContext) {
                this.ctx = new AudioContext();
            }
        }
        if (this.ctx && this.ctx.state === 'suspended') {
            this.ctx.resume();
        }
    }

    initUnlockEvents() {
        const unlock = () => {
            this.initContext();
            if (this.musicEnabled && !this.isMusicPlaying) {
                this.startMusic();
            }
            window.removeEventListener('click', unlock);
            window.removeEventListener('touchstart', unlock);
        };
        window.addEventListener('click', unlock, { once: true });
        window.addEventListener('touchstart', unlock, { once: true });
    }

    toggleSound() {
        this.soundEnabled = !this.soundEnabled;
        localStorage.setItem('sweet_sfx', this.soundEnabled);
        if (this.soundEnabled) this.pop();
        return this.soundEnabled;
    }

    toggleMusic() {
        this.musicEnabled = !this.musicEnabled;
        localStorage.setItem('sweet_music', this.musicEnabled);
        if (this.musicEnabled) {
            this.startMusic();
        } else {
            this.stopMusic();
        }
        return this.musicEnabled;
    }

    pop(freq = 520) {
        if (!this.soundEnabled) return;
        this.initContext();
        if (!this.ctx) return;

        try {
            const osc = this.ctx.createOscillator();
            const gain = this.ctx.createGain();
            const now = this.ctx.currentTime;

            osc.type = 'sine';
            osc.frequency.setValueAtTime(freq, now);
            osc.frequency.exponentialRampToValueAtTime(freq * 1.6, now + 0.04);
            osc.frequency.exponentialRampToValueAtTime(freq * 0.4, now + 0.11);

            gain.gain.setValueAtTime(0.2, now);
            gain.gain.exponentialRampToValueAtTime(0.001, now + 0.11);

            osc.connect(gain);
            gain.connect(this.ctx.destination);

            osc.start(now);
            osc.stop(now + 0.12);
        } catch (e) {}
    }

    boing() {
        if (!this.soundEnabled) return;
        this.initContext();
        if (!this.ctx) return;

        try {
            const osc = this.ctx.createOscillator();
            const gain = this.ctx.createGain();
            const now = this.ctx.currentTime;

            osc.type = 'sine';
            osc.frequency.setValueAtTime(260, now);
            osc.frequency.linearRampToValueAtTime(580, now + 0.1);
            osc.frequency.linearRampToValueAtTime(320, now + 0.2);
            osc.frequency.linearRampToValueAtTime(500, now + 0.28);

            gain.gain.setValueAtTime(0.18, now);
            gain.gain.exponentialRampToValueAtTime(0.001, now + 0.3);

            osc.connect(gain);
            gain.connect(this.ctx.destination);

            osc.start(now);
            osc.stop(now + 0.31);
        } catch (e) {}
    }

    chime() {
        if (!this.soundEnabled) return;
        this.initContext();
        if (!this.ctx) return;

        try {
            const notes = [523.25, 659.25, 783.99, 1046.50];
            notes.forEach((freq, idx) => {
                const now = this.ctx.currentTime + (idx * 0.05);
                const osc = this.ctx.createOscillator();
                const gain = this.ctx.createGain();

                osc.type = 'sine';
                osc.frequency.setValueAtTime(freq, now);

                gain.gain.setValueAtTime(0.1, now);
                gain.gain.exponentialRampToValueAtTime(0.001, now + 0.3);

                osc.connect(gain);
                gain.connect(this.ctx.destination);

                osc.start(now);
                osc.stop(now + 0.31);
            });
        } catch (e) {}
    }

    fanfare() {
        if (!this.soundEnabled) return;
        this.initContext();
        if (!this.ctx) return;

        try {
            const melody = [
                { note: 523.25, dur: 0.14 },
                { note: 659.25, dur: 0.14 },
                { note: 783.99, dur: 0.14 },
                { note: 1046.50, dur: 0.35 },
                { note: 880.00, dur: 0.14 },
                { note: 1046.50, dur: 0.5 }
            ];

            let offset = 0;
            melody.forEach(item => {
                const now = this.ctx.currentTime + offset;
                const osc = this.ctx.createOscillator();
                const gain = this.ctx.createGain();

                osc.type = 'triangle';
                osc.frequency.setValueAtTime(item.note, now);

                gain.gain.setValueAtTime(0.15, now);
                gain.gain.exponentialRampToValueAtTime(0.001, now + item.dur);

                osc.connect(gain);
                gain.connect(this.ctx.destination);

                osc.start(now);
                osc.stop(now + item.dur + 0.05);
                offset += item.dur * 0.85;
            });
        } catch (e) {}
    }

    blow() {
        if (!this.soundEnabled) return;
        this.initContext();
        if (!this.ctx) return;

        try {
            const bufferSize = this.ctx.sampleRate * 0.35;
            const buffer = this.ctx.createBuffer(1, bufferSize, this.ctx.sampleRate);
            const data = buffer.getChannelData(0);
            for (let i = 0; i < bufferSize; i++) {
                data[i] = Math.random() * 2 - 1;
            }

            const noise = this.ctx.createBufferSource();
            noise.buffer = buffer;

            const filter = this.ctx.createBiquadFilter();
            filter.type = 'bandpass';
            filter.frequency.setValueAtTime(500, this.ctx.currentTime);
            filter.frequency.exponentialRampToValueAtTime(180, this.ctx.currentTime + 0.35);

            const gain = this.ctx.createGain();
            gain.gain.setValueAtTime(0.18, this.ctx.currentTime);
            gain.gain.exponentialRampToValueAtTime(0.001, this.ctx.currentTime + 0.35);

            noise.connect(filter);
            filter.connect(gain);
            gain.connect(this.ctx.destination);

            noise.start();
        } catch (e) {}
    }

    typeTick() {
        if (!this.soundEnabled) return;
        this.initContext();
        if (!this.ctx) return;

        try {
            const osc = this.ctx.createOscillator();
            const gain = this.ctx.createGain();
            const now = this.ctx.currentTime;

            osc.type = 'triangle';
            osc.frequency.setValueAtTime(1400 + Math.random() * 400, now);

            gain.gain.setValueAtTime(0.04, now);
            gain.gain.exponentialRampToValueAtTime(0.001, now + 0.03);

            osc.connect(gain);
            gain.connect(this.ctx.destination);

            osc.start(now);
            osc.stop(now + 0.035);
        } catch (e) {}
    }

    startMusic() {
        this.initContext();
        if (!this.ctx) return;
        this.isMusicPlaying = true;

        const chords = [
            [261.63, 329.63, 392.00, 523.25], // C
            [196.00, 246.94, 293.66, 392.00], // G
            [220.00, 261.63, 329.63, 440.00], // Am
            [174.61, 220.00, 261.63, 349.23], // F
            [261.63, 329.63, 392.00, 523.25], // C
            [196.00, 246.94, 293.66, 392.00], // G
            [174.61, 261.63, 349.23, 523.25], // F -> C
            [261.63, 392.00, 523.25, 659.25]  // Flourish
        ];

        let chordIdx = 0;
        const playBeat = () => {
            if (!this.isMusicPlaying) return;
            const currentChord = chords[chordIdx % chords.length];
            chordIdx++;

            currentChord.forEach((freq, noteIdx) => {
                const noteTime = this.ctx.currentTime + (noteIdx * 0.16);
                const osc = this.ctx.createOscillator();
                const gain = this.ctx.createGain();

                osc.type = 'sine';
                osc.frequency.setValueAtTime(freq, noteTime);

                gain.gain.setValueAtTime(0.035, noteTime);
                gain.gain.exponentialRampToValueAtTime(0.0001, noteTime + 1.1);

                osc.connect(gain);
                gain.connect(this.ctx.destination);

                osc.start(noteTime);
                osc.stop(noteTime + 1.15);
            });
        };

        playBeat();
        this.musicInterval = setInterval(playBeat, 1500);
    }

    stopMusic() {
        this.isMusicPlaying = false;
        if (this.musicInterval) {
            clearInterval(this.musicInterval);
            this.musicInterval = null;
        }
    }
}

window.sweetSFX = new SweetSoundEngine();
