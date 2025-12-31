<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('levels', function (Blueprint $table) {
        $table->id();
        $table->string('nama_world'); // School, Home, atau Body
        $table->integer('minggu_ke');
        $table->json('data_soal'); // Tempat menyimpan kata-kata Arab
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('levels');
    }
};
