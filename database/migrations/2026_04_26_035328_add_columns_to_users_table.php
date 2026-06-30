<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Kolom untuk fitur Settings (Tema)
            $table->string('theme')->default('light'); // light atau dark
            
            // Kolom untuk fitur Gamifikasi (XP & Level)
            $table->integer('xp')->default(0);
            $table->integer('level')->default(1);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['theme', 'xp', 'level']);
        });
    }
};