<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('nama_anak'); 
            $table->string('kelas');
            // Menghubungkan anak dengan orang tuanya
            $table->unsignedBigInteger('parent_id')->nullable(); 
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('students'); // Perbaiki dari 'parents' ke 'students'
    }
};