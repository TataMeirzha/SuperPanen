<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengirim_id')->constrained('users')->onDelete('cascade');
            $table->string('judul');
            $table->enum('kategori', ['masalah_sewa', 'masalah_data', 'masalah_teknis', 'permintaan_perubahan', 'lainnya']);
            $table->text('deskripsi');
            $table->enum('status', ['pending', 'diproses', 'selesai'])->default('pending');
            $table->text('balasan')->nullable();
            $table->foreignId('dibalas_oleh')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('dibalas_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporans');
    }
};