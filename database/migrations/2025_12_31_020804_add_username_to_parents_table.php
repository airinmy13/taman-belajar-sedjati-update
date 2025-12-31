<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('parents', function (Blueprint $table) {
            if (!Schema::hasColumn('parents', 'username')) {
                $table->string('username')->unique()->nullable()->after('parent_name');
            }
            if (!Schema::hasColumn('parents', 'phone')) {
                $table->string('phone')->nullable()->after('email');
            }
            // Gender is assumed to exist from previous log
        });
    }

    public function down(): void
    {
        Schema::table('parents', function (Blueprint $table) {
            if (Schema::hasColumn('parents', 'username')) {
                $table->dropColumn('username');
            }
            if (Schema::hasColumn('parents', 'phone')) {
                $table->dropColumn('phone');
            }
        });
    }
};
