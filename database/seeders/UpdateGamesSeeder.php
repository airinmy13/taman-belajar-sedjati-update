<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateGamesSeeder extends Seeder
{
    public function run()
    {
        // Update Game 1: Mencocokan Bahasa Inggris - Arab
        DB::table('games')->where('slug', 'mencocokan-bahasa-inggris-arab')->update([
            'title' => '🌍 Petualangan Bahasa Arab',
            'description' => 'Ayo belajar bahasa Arab dengan cara yang seru! Cocokkan kata-kata bahasa Inggris dengan bahasa Arab. Siapa yang paling cepat?',
            'category' => 'Bahasa Arab',
            'thumbnail' => null,
            'is_active' => true,
        ]);

        // Update Game 2: TTS Alat Tulis
        DB::table('games')->where('slug', 'tts-alat-tulis')->update([
            'title' => '🧩 Teka-Teki Silang Seru',
            'description' => 'Apa kamu bisa menebak benda apakah itu? Isi teka-teki silang dengan nama-nama alat tulis! Asah otakmu!',
            'category' => 'Teka-Teki',
            'thumbnail' => null,
            'is_active' => true,
        ]);

        // Update Game 3: Menghitung Huruf Hijaiyah
        DB::table('games')->where('slug', 'menghitung-huruf-hijaiyah')->update([
            'title' => '📖 Petualangan Huruf Hijaiyah',
            'description' => 'Berapa banyak huruf hijaiyah yang ada? Ayo hitung bersama dan pelajari huruf-huruf Arab dengan cara yang menyenangkan!',
            'category' => 'Bahasa Arab',
            'thumbnail' => null,
            'is_active' => true,
        ]);
    }
}
