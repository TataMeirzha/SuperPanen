<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('permintaan_sewas', function (Blueprint $table) {
            $table->string('foto_ktp')->nullable()->after('catatan_mitra');
        });
    }

    public function down(): void
    {
        Schema::table('permintaan_sewas', function (Blueprint $table) {
            $table->dropColumn('foto_ktp');
        });
    }
};