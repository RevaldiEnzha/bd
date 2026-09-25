<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $settings['title'] ?? 'Selamat Ulang Tahun!' }}</title>
    
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🍓</text></svg>">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@600;700&family=Comfortaa:wght@500;700&family=Quicksand:wght@500;600;700&display=swap" rel="stylesheet">
    
    <!-- Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
    <!-- Theme Dynamic Variables -->
    <style>
        :root {
            --primary: {{ $themeColors['primary'] }};
            --primary-light: {{ $themeColors['primary_light'] }};
            --secondary: {{ $themeColors['secondary'] }};
            --accent: {{ $themeColors['accent'] }};
            --bg-start: {{ $themeColors['bg_start'] }};
            --bg-mid: {{ $themeColors['bg_mid'] }};
            --bg-end: {{ $themeColors['bg_end'] }};
            --card-bg: {{ $themeColors['card_bg'] }};
            --text: {{ $themeColors['text'] }};
            --text-soft: {{ $themeColors['text_soft'] }};
            --border: {{ $themeColors['border'] }};
            --shadow: {{ $themeColors['shadow'] }};
        }
    </style>
</head>
<body>

<!-- Ambient Moving Clouds -->
<div class="bg-ambient-decor">
    <div class="cloud cloud-1"></div>
    <div class="cloud cloud-2"></div>
    <div class="cloud cloud-3"></div>
</div>

<!-- Header (Brand & Desktop Navbar) -->
<header class="sweet-top-header">
    <a href="{{ route('home') }}" class="brand-logo">
        <span class="logo-icon">🍰</span>
        <span>{{ $settings['nickname'] ?? 'Ulang Tahun' }}</span>
    </a>

    <!-- Desktop Navigation -->
    <ul class="desktop-nav">
        <li>
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">
                <span>🏠</span> Beranda
            </a>
        </li>
        <li>
            <a href="{{ route('cake') }}" class="{{ request()->routeIs('cake') ? 'active' : '' }}">
                <span>🎂</span> Tiup Lilin
            </a>
        </li>
        <li>
            <a href="{{ route('letter') }}" class="{{ request()->routeIs('letter') ? 'active' : '' }}">
                <span>💌</span> Surat
            </a>
        </li>
        <li>
            <a href="{{ route('memories') }}" class="{{ request()->routeIs('memories') ? 'active' : '' }}">
                <span>📸</span> Kenangan
            </a>
        </li>
        <li>
            <a href="{{ route('wishes') }}" class="{{ request()->routeIs('wishes') ? 'active' : '' }}">
                <span>🌟</span> Harapan & Doa
            </a>
        </li>
        <li>
            <a href="{{ route('game') }}" class="{{ request()->routeIs('game') ? 'active' : '' }}">
                <span>🎮</span> Mini Game
            </a>
        </li>
    </ul>

    <!-- Quick Action Buttons -->
    <div class="header-actions">
        <button class="btn-icon-round" id="btnSettingsModal" title="Pengaturan & Personalisasi" data-custom-sfx="true">
            ⚙️
        </button>
        <button class="btn-icon-round" id="btnToggleMusicNav" title="Putar Musik Manis" data-custom-sfx="true">
            🎵
        </button>
    </div>
</header>

<!-- Main Page Content -->
<main>
    @yield('content')
</main>

<!-- Mobile Bottom Navigation Dock (Optimized for 1-Thumb Touch) -->
<nav class="mobile-bottom-dock">
    <a href="{{ route('home') }}" class="dock-item {{ request()->routeIs('home') ? 'active' : '' }}">
        <span class="dock-icon">🏠</span>
        <span>Beranda</span>
    </a>
    <a href="{{ route('cake') }}" class="dock-item {{ request()->routeIs('cake') ? 'active' : '' }}">
        <span class="dock-icon">🎂</span>
        <span>Lilin</span>
    </a>
    <a href="{{ route('letter') }}" class="dock-item {{ request()->routeIs('letter') ? 'active' : '' }}">
        <span class="dock-icon">💌</span>
        <span>Surat</span>
    </a>
    <a href="{{ route('memories') }}" class="dock-item {{ request()->routeIs('memories') ? 'active' : '' }}">
        <span class="dock-icon">📸</span>
        <span>Galeri</span>
    </a>
    <a href="{{ route('wishes') }}" class="dock-item {{ request()->routeIs('wishes') ? 'active' : '' }}">
        <span class="dock-icon">🌟</span>
        <span>Doa</span>
    </a>
    <a href="{{ route('game') }}" class="dock-item {{ request()->routeIs('game') ? 'active' : '' }}">
        <span class="dock-icon">🎮</span>
        <span>Game</span>
    </a>
</nav>

<!-- Floating Controls (Confetti & Sound) -->
<div class="sweet-floating-controls">
    <button class="control-pill" id="btnBurstConfetti" title="Taburkan Konfeti!" data-custom-sfx="true">
        <span>🎉</span> Konfeti
    </button>
    <button class="control-pill" id="btnToggleAudio" title="Suara ON/OFF" data-custom-sfx="true">
        <span id="audioIcon">🔊</span> <span id="audioStatusText">ON</span>
    </button>
</div>

<!-- Settings / Customizer Modal -->
<div class="sweet-modal-backdrop" id="settingsModal">
    <div class="sweet-modal-box">
        <button class="modal-close-btn" id="btnCloseSettings">✕</button>
        <div style="text-align: center; margin-bottom: 16px;">
            <div style="font-size: 2rem; margin-bottom: 2px;">🎀</div>
            <h3 style="font-family: var(--font-heading); color: var(--accent); font-size: 1.35rem;">Personalisasi Manis</h3>
            <p style="font-size: 0.82rem; color: var(--text-soft);">Sesuaikan nama bidadari & tema warna pastel favorit!</p>
        </div>

        <form id="settingsForm">
            <div style="margin-bottom: 12px;">
                <label style="font-weight: 700; font-size: 0.82rem; display: block; margin-bottom: 4px;">Nama Lengkap / Spesial:</label>
                <input type="text" name="name" class="wish-input-box" value="{{ $settings['name'] ?? '' }}" required>
            </div>

            <div style="margin-bottom: 12px;">
                <label style="font-weight: 700; font-size: 0.82rem; display: block; margin-bottom: 4px;">Nama Panggilan (Singkat):</label>
                <input type="text" name="nickname" class="wish-input-box" value="{{ $settings['nickname'] ?? '' }}" required>
            </div>

            <div style="margin-bottom: 12px;">
                <label style="font-weight: 700; font-size: 0.82rem; display: block; margin-bottom: 4px;">Ulang Tahun ke- :</label>
                <input type="number" name="age" class="wish-input-box" value="{{ (int)($settings['age'] ?? 21) }}" min="1" max="120" required>
            </div>

            <div style="margin-bottom: 16px;">
                <label style="font-weight: 700; font-size: 0.82rem; display: block; margin-bottom: 4px;">Tema Warna Pastel:</label>
                <select name="theme" class="wish-input-box" style="cursor: pointer;">
                    <option value="strawberry" {{ ($settings['theme'] ?? '') === 'strawberry' ? 'selected' : '' }}>🍓 Strawberry Milkshake (Pink Manis)</option>
                    <option value="peach" {{ ($settings['theme'] ?? '') === 'peach' ? 'selected' : '' }}>🍑 Peach Blossom (Hangat & Ceria)</option>
                    <option value="lavender" {{ ($settings['theme'] ?? '') === 'lavender' ? 'selected' : '' }}>💜 Dreamy Lavender (Aesthetic Magis)</option>
                    <option value="mint" {{ ($settings['theme'] ?? '') === 'mint' ? 'selected' : '' }}>🍃 Mint Vanilla (Segar & Lembut)</option>
                </select>
            </div>

            <button type="submit" class="btn-sweet-primary" style="width: 100%; justify-content: center;">
                Simpan Perubahan
            </button>
        </form>
    </div>
</div>

<!-- Sweet Footer -->
<footer class="sweet-footer">
    <p>Dibuat dengan sepenuh hati, jiwa, dan raga untuk sahabat baik bernama: <strong>{{ $settings['name'] ?? 'Bidadari' }}</strong></p>
</footer>

<!-- Scripts -->
<script src="{{ asset('js/sfx.js') }}"></script>
<script src="{{ asset('js/effects.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>
@yield('scripts')
</body>
</html>
