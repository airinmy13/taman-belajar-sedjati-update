<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OrangTua;
use App\Models\Student;
use App\Models\Game;
use App\Models\Question;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create sample parents
        $parent1 = OrangTua::create([
            'parent_name' => 'Budi Santoso',
            'child_name' => 'Ani, Budi Jr',
            'email' => 'budi@test.com',
            'password' => Hash::make('password123')
        ]);

        $parent2 = OrangTua::create([
            'parent_name' => 'Siti Rahayu',
            'child_name' => 'Citra',
            'email' => 'siti@test.com',
            'password' => Hash::make('password123')
        ]);

        // Create sample students
        Student::create([
            'nama_anak' => 'Ani Santoso',
            'kelas' => '3',
            'parent_id' => $parent1->id
        ]);

        Student::create([
            'nama_anak' => 'Budi Santoso Jr',
            'kelas' => '5',
            'parent_id' => $parent1->id
        ]);

        Student::create([
            'nama_anak' => 'Citra Rahayu',
            'kelas' => '4',
            'parent_id' => $parent2->id
        ]);

        // Create sample games
        $game1 = Game::create([
            'title' => 'Teka-Teki Silang Bahasa Arab',
            'slug' => 'tts-bahasa-arab',
            'description' => 'Asah kemampuan bahasa Arab kamu dengan teka-teki silang yang seru!',
            'category' => 'Bahasa Arab',
            'is_active' => true,
            'order' => 1
        ]);

        $game2 = Game::create([
            'title' => 'Tebak Gambar Hewan',
            'slug' => 'tebak-gambar-hewan',
            'description' => 'Tebak nama hewan dalam bahasa Arab dari gambar yang ditampilkan!',
            'category' => 'Bahasa Arab',
            'is_active' => true,
            'order' => 2
        ]);

        $game3 = Game::create([
            'title' => 'Menghitung Huruf Hijaiyah',
            'slug' => 'hitung-hijaiyah',
            'description' => 'Hitung berapa banyak huruf hijaiyah tertentu dalam sebuah kata!',
            'category' => 'Bahasa Arab',
            'is_active' => true,
            'order' => 3
        ]);

        // Create sample questions for game 1 (TTS)
        Question::create([
            'game_id' => $game1->id,
            'question_text' => 'Bahasa Arab dari "Rumah" adalah?',
            'correct_answer' => 'Bait',
            'points' => 10,
            'difficulty' => 'easy',
            'is_active' => true
        ]);

        Question::create([
            'game_id' => $game1->id,
            'question_text' => 'Bahasa Arab dari "Sekolah" adalah?',
            'correct_answer' => 'Madrasah',
            'points' => 10,
            'difficulty' => 'easy',
            'is_active' => true
        ]);

        Question::create([
            'game_id' => $game1->id,
            'question_text' => 'Bahasa Arab dari "Buku" adalah?',
            'correct_answer' => 'Kitab',
            'points' => 10,
            'difficulty' => 'easy',
            'is_active' => true
        ]);

        // Create sample questions for game 2 (Tebak Gambar)
        Question::create([
            'game_id' => $game2->id,
            'question_text' => 'Hewan yang berkaki empat dan suka makan rumput adalah?',
            'correct_answer' => 'Kambing',
            'points' => 15,
            'difficulty' => 'medium',
            'is_active' => true
        ]);

        Question::create([
            'game_id' => $game2->id,
            'question_text' => 'Hewan yang bisa terbang dan berkokok di pagi hari adalah?',
            'correct_answer' => 'Ayam',
            'points' => 10,
            'difficulty' => 'easy',
            'is_active' => true
        ]);

        // Create sample questions for game 3
        Question::create([
            'game_id' => $game3->id,
            'question_text' => 'Berapa jumlah huruf "alif" dalam kata "Madrasah"?',
            'correct_answer' => '2',
            'points' => 15,
            'difficulty' => 'medium',
            'is_active' => true
        ]);

        $this->command->info('✅ Sample data created successfully!');
        $this->command->info('');
        $this->command->info('📧 Parent Login Credentials:');
        $this->command->info('   Email: budi@test.com | Password: password123');
        $this->command->info('   Email: siti@test.com | Password: password123');
        $this->command->info('');
        $this->command->info('👶 Student Login:');
        $this->command->info('   Nama: Ani Santoso | Kelas: 3');
        $this->command->info('   Nama: Budi Santoso Jr | Kelas: 5');
        $this->command->info('   Nama: Citra Rahayu | Kelas: 4');
    }
}
