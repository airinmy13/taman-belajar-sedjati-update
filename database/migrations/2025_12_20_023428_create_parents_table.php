<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('parents', function (Blueprint $table) {
            $table->id();
            $table->string('parent_name');
            $table->string('child_name');
            $table->string('email')->unique(); // Tambahkan Email untuk Login
            $table->string('password');       // Tambahkan Password untuk Login
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('parents');
    }
};