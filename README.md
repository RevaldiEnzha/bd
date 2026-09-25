# 🎂 Sweet Birthday App (Laravel Edition) 💖

Website ucapan ulang tahun interaktif bertema pastel manis (*aesthetic & cute*), dibangun menggunakan arsitektur modern **Laravel 11**, database **SQLite**, serta desain **Mobile-First** yang responsif dan nyaman digunakan di ponsel maupun laptop!

---

## 📱 Desain Mobile-First & Pengalaman Pengguna yang Bersih
- **Navigasi Dock Bawah di Ponsel**: Pada layar handphone, navigasi beralih ke *Bottom Navigation Dock* yang mudah dijangkau dengan 1 ibu jari. Pada layar laptop/desktop, navigasi otomatis tampil sebagai *top pill navbar*.
- **Bebas Gangguan Jejak Kursor**: Efek partikel kursor yang mengikuti setiap pergerakan mouse telah dihapus sepenuhnya sesuai permintaan, sehingga tampilan tetap bersih, tenang, dan tidak bikin pusing.
- **Efek Interaksi Tetap Lucu & Manis**: Sentuhan pada tombol, lilin, kartu, dan hadiah tetap menghasilkan animasi membal (*bouncy / jelly*), letupan bintang mini, dan efek suara *chime/pop* yang menggemaskan.
- **Ramah Layar Sentuh (*Touch-Friendly*)**:
  - **Kartu Gosok (*Scratch Card*)**: Dapat digosok langsung dengan jari di layar ponsel tanpa scroll halaman terganggu.
  - **Mini Game Tangkap Kado**: Dilengkapi tombol sentuh besar ⬅️ **Kiri** dan **Kanan** ➡️ untuk kontrol mudah dengan ibu jari, selain kontrol geser layar dan tombol keyboard.
  - **Tiup Lilin**: Sentuh lilin untuk memadamkannya satu per satu dengan animasi kepulan asap dan suara selebrasi.

---

## 🏛️ Arsitektur Laravel
- **Routes (`routes/web.php`)**:
  - `GET /` -> `BirthdayController@home`
  - `GET /cake` -> `BirthdayController@cake`
  - `GET /letter` -> `BirthdayController@letter`
  - `GET /memories` -> `BirthdayController@memories`
  - `GET /wishes` -> `BirthdayController@wishes`
  - `GET /game` -> `BirthdayController@game`
  - API Routes: `/api/wishes`, `/api/wishes/{id}/like`, `/api/memories`, `/api/memories/{id}/like`, `/api/settings`
- **Models & Migrations**:
  - `Wish`: Menyimpan pesan doa, warna sticky note, stiker, dan jumlah like.
  - `Memory`: Menyimpan kenangan polaroid, tanggal, catatan, dan jumlah like.
  - `BirthdaySetting`: Menyimpan profil yang berulang tahun (nama, nama panggilan, usia, tema warna, isi surat).
- **Controller (`app/Http/Controllers/BirthdayController.php`)**:
  - Mengelola logika rendering halaman, pemrosesan placeholder template surat, dan respon API JSON.
- **Views (`resources/views/`)**:
  - `layouts/app.blade.php`: Layout master dengan tema dinamis, modal kustomisasi, tombol suara, dan navigasi ganda (Desktop Top Navbar & Mobile Bottom Dock).
  - `pages/home.blade.php`, `cake.blade.php`, `letter.blade.php`, `memories.blade.php`, `wishes.blade.php`, `game.blade.php`.
- **Assets (`public/`)**:
  - `public/css/style.css`: Desain responsif, font Google (*Comfortaa, Quicksand, Caveat*), tema pastel (*Strawberry, Peach, Lavender, Mint*).
  - `public/js/sfx.js`: Web Audio API procedural synthesizer (pop, chime, fanfare, blow, lofi music box).
  - `public/js/effects.js`: Letupan bintang pada klik/sentuhan, konfeti canvas, toast alert.
  - `public/js/main.js`: Modal pengaturan dan integrasi API.

---

## 🚀 Cara Menjalankan Aplikasi

Aplikasi saat ini telah aktif di port `8000`:
👉 **[http://127.0.0.1:8000](http://127.0.0.1:8000)**

Untuk menjalankan ulang sewaktu-waktu dari terminal:
```powershell
cd "C:\Users\Mr. Enzha\.gemini\antigravity\scratch\sweet-birthday-app"
php artisan serve
```
Lalu buka `http://127.0.0.1:8000` di peramban favorit Anda!
