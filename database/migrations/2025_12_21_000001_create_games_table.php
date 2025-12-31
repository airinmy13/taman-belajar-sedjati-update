<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Nama game: "Teka-Teki Silang", "Tebak Gambar"
            $table->string('slug')->unique(); // URL-friendly: "tts", "tebak-gambar"
            $table->text('description')->nullable(); // Deskripsi game
            $table->string('thumbnail')->nullable(); // Path ke gambar thumbnail
            $table->string('category')->nullable(); // Kategori game
            $table->boolean('is_active')->default(true); // Status aktif/nonaktif
            $table->integer('order')->default(0); // Urutan tampilan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
