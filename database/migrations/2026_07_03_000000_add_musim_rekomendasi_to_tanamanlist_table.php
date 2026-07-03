<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tanamanlist', function (Blueprint $table) {
            $table->enum('musim_rekomendasi', ['hujan', 'kemarau', 'pancaroba'])
                ->nullable()
                ->after('nama');
        });
    }

    public function down(): void
    {
        Schema::table('tanamanlist', function (Blueprint $table) {
            $table->dropColumn('musim_rekomendasi');
        });
    }
};