<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GamesSeeder extends Seeder
{
    public function run()
    {
        // Check if games already exist, if not create them
        $games = [
            [
                'title' => '🌍 Petualangan Bahasa Arab',
                'slug' => 'mencocokan-bahasa-inggris-arab',
                'description' => 'Ayo belajar bahasa Arab dengan cara yang seru! Cocokkan kata-kata bahasa Inggris dengan bahasa Arab. Siapa yang paling cepat?',
                'category' => 'Bahasa Arab',
                'is_active' => true,
            ],
            [
                'title' => '🧩 Teka-Teki Silang Seru',
                'slug' => 'tts-alat-tulis',
                'description' => 'Apa kamu bisa menebak benda apakah itu? Isi teka-teki silang dengan nama-nama alat tulis! Asah otakmu!',
                'category' => 'Teka-Teki',
                'is_active' => true,
            ],
            [
                'title' => '📖 Petualangan Huruf Hijaiyah',
                'slug' => 'menghitung-huruf-hijaiyah',
                'description' => 'Berapa banyak huruf hijaiyah yang ada? Ayo hitung bersama dan pelajari huruf-huruf Arab dengan cara yang menyenangkan!',
                'category' => 'Bahasa Arab',
                'is_active' => true,
            ],
        ];

        foreach ($games as $game) {
            // Check if game exists
            $exists = DB::table('games')->where('slug', $game['slug'])->exists();
            
            if (!$exists) {
                DB::table('games')->insert([
                    'title' => $game['title'],
                    'slug' => $game['slug'],
                    'description' => $game['description'],
                    'category' => $game['category'],
                    'is_active' => $game['is_active'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                echo "Created game: {$game['title']}\n";
            } else {
                echo "Game already exists: {$game['title']}\n";
            }
        }
    }
}
