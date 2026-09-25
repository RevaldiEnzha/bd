<?php

namespace Database\Seeders;

use App\Models\Wish;
use App\Models\Memory;
use App\Models\BirthdaySetting;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Birthday Settings
        |--------------------------------------------------------------------------
        */

        $settings = [
            'name' => 'Naufa',
            'nickname' => 'LingLung',
            'birthdate' => '2026-09-26',
            'age' => '20',
            'theme' => 'lavender',
            'header_badge' => 'Hari Spesial Naufa Aulia',
            'title' => 'HaBeDe, Linglung! 🎂',
            'tagline' => 'Semoga datang banyak hal baik di hari spesial ini ',
            'letter_greeting' => 'Hai teman seangkatan😹,',

            'letter_body' => "Selamat bertambah usia yang ke-{age} ya, Ling! 🎉\n\n"
                . "Di hari istimewa ini, kita cuma mau ngomong makasih banyak ya ling udah mau temenan sama kita, "
                . "walau kadang kita ngeselin sama banyak kurangnya, ira tetep pengen temenan sama kita. "
                . "Mungkin kita sama ira temenan gara2 sekelas doang awalnya, tapi ternyata keterusan sampe pindah kelas "
                . "malah sampe univ juga🙂‍↕️. Malah jadi bareng terus gini\n\n"

                . "Walau semenjak masuk kampus kita sama ira rasanya jarang nge-chat, tapi tetep kita sih nganggep ira "
                . "temen paling akrab kita di kampus (ya gatau sih kalo ira gimana🙄).\n\n"

                . "Inget banget waktu pulang bareng naik kereta. Makasih banget loh udah nuntun kita yang bener-bener awam "
                . "ini dengan kesabaran maksimal; dari beliin tiket, nungguin di lobi, sampe naik kereta terus sampe di cerbon. "
                . "Mungkin pas itu kita banyak omong sampe ganggu ira karena first time banget naik kereta😭.\n\n"

                . "Terus juga kalo gasalah semester depannya kita pulang naik kereta sendiri. Karena masih agak bingung sama "
                . "prosesnya, kita jadi banyak banget nge-chat ira pas itu. kita inget banget pas itu tuh ira sebenernya lagi sibuk "
                . "(praktikum kalo gasalah), tapi kita malah nanya terus kayak pesan spam... maap ya😙\n\n"

                . "Sampe akhirnya, sekarang gak kerasa bentar lagi ira bakal lulus (Amin!). Sumpahh, padahal rasanya baru kemarin "
                . "banget loh keterima bareng, tuker info tentang ospek masing-masing, ngeluh bareng, sekarang malah nanyainnya "
                . "tugas akhir😩. apa gara-gara kehidupan di teknik terlalu santai, ya? jadi ga kerasa gini? hehe😏\n\n"

                . "Pokoknya... Makasih ya udah baik terus sama kita, sama orang-orang di sekitar ira.\n"
                . "Semoga ira juga selalu dikelilingi orang-orang yang baik sama ira, yang ikhlas sama ira, bukan yang munafik. "
                . "Gak ikhlas banget kalo orang sebaik ira malah dikelilingin sama orang yang gabisa ngehargain kebaikan ira. \n"
                . "Ya, walau kita tau ira ga sebego itu sih buat milah-milah temen\n\n"

                . "Semoga di lembaran usia ira yang baru ini:\n"
                . "✨ Semua doa ira didengar dan dikabulkan satu per satu.\n"
                . "🌸 Ira selalu dikelilingi orang-orang yang tulus.\n"
                . "🍓 Hidup ira seterusnya selalu dipenuhi ketenangan, kebahagiaan, dan tawa.\n"
                . "😊 Jangan capek senyum, karena senyum itu ibadah.\n\n"

                . "Tetep terus jadi Linglung yang keren abizz, ya! \n"
                . "HABEDE! ",

            'letter_sender' => 'Dari seorang sahabat yang sangat baik hati dan tidak pernah sombong 😊',

            'letter_postscript' => 'P.S. Jangan lupa jalan-jalan bareng sebelum ira lulus! (wajib loh ya)',
        ];

        foreach ($settings as $key => $value) {
            BirthdaySetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Wishes
        |--------------------------------------------------------------------------
        */

        Wish::create([
            'name' => 'Sahabat Terbaik dan Terhebat ?',
            'message' => "HABEDE dah pokoknya! Semoga rezeki ira seluas samudra, makin sukses, makin baik, dan ga pernah sombong lagi.\n"
                . "Jangan lupa traktir!",
            'sticker' => '',
            'color' => 'pink',
            'likes' => 27,
        ]);


        /*
        |--------------------------------------------------------------------------
        | Memories
        |--------------------------------------------------------------------------
        */

        Memory::create([
            'title' => 'praktek biologi',
            'date_label' => 'Praktek Bareng',
            'caption' => 'Jas Putihnya keren ya ternyata',
            'likes' => 0,
            'theme_color' => '#ffd6df',
            'sticker' => '🌸',
        ]);

        Memory::create([
            'title' => 'perkawinan',
            'date_label' => 'Nikah di Rumah LingLung',
            'caption' => 'Dika Kawin😹',
            'likes' => 0,
            'theme_color' => '#ffe5d9',
            'sticker' => '🎂',
        ]);

        Memory::create([
            'title' => 'praktek biologi 2',
            'date_label' => 'Foto Praktek di Tangga',
            'caption' => 'Sama abis praktek, tapi fotonya di tangga',
            'likes' => 0,
            'theme_color' => '#eeddff',
            'sticker' => '🧸',
        ]);

        Memory::create([
            'title' => 'foto yearbook',
            'date_label' => 'Keluarga Besar?',
            'caption' => 'Bagus sih ini, cuma muka si kacamata kayak gak ikhlas',
            'likes' => 0,
            'theme_color' => '#d8f3ec',
            'sticker' => '✨',
        ]);
    }
}