<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BirthdaySetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
    ];

    public static function get(string $key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    public static function set(string $key, $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    public static function getAll(): array
    {
        $all = static::pluck('value', 'key')->toArray();

        $defaults = [
            'name' => 'Putri Cantik',
            'nickname' => 'Si Cantik',
            'birthdate' => '2026-09-25',
            'age' => '21',
            'theme' => 'strawberry',
            'header_badge' => 'Hari Spesial untuk Bidadari Manis',
            'title' => 'Selamat Ulang Tahun, Manisku! 🎂✨',
            'tagline' => 'Semoga hari ini seindah senyummu dan sehangat pelukanmu 🌸',
            'letter_greeting' => 'Hai orang favoritku,',
            'letter_body' => "Selamat bertambah usia yang ke-{age}! 🎉\n\nDi hari yang seistimewa ini, aku cuma mau bilang terima kasih banyak sudah hadir di dunia dan membawa begitu banyak warna manis ke dalam hidup orang-orang di sekitarmu.\n\nSemoga di lembaran usiamu yang baru ini:\n✨ Semua doa baikmu didengar dan dikabulkan satu per satu.\n🌸 Kamu selalu dikelilingi orang-orang yang tulus menyayangimu.\n🍓 Hatimu selalu dipenuhi ketenangan, kebahagiaan, dan tawa renyah.\n🍰 Jangan pernah lelah tersenyum, karena senyummu itu bikin dunia terasa lebih hangat!\n\nTetaplah jadi dirimu yang luar biasa, hangat, dan manis ya! Selamat ulang tahun! 💖🧸",
            'letter_sender' => 'Dari seseorang yang selalu mendoakanmu 💖',
            'letter_postscript' => 'P.S. Jangan lupa makan kue yang banyak dan simpan sepotong untukku ya! 🍰😋'
        ];

        return array_merge($defaults, $all);
    }
}
