<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('parent_registrations', function (Blueprint $table) {
            $table->id();
            // Parent data
            $table->string('parent_name');
            $table->string('username')->unique();
            $table->string('password');
            $table->string('email');
            $table->string('phone');
            $table->enum('gender', ['L', 'P']); // L=Laki-laki, P=Perempuan
            
            // Child data
            $table->string('child_name');
            $table->string('child_class');
            
            // Registration status
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->unsignedBigInteger('reviewed_by')->nullable(); // admin_id
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parent_registrations');
    }
};
