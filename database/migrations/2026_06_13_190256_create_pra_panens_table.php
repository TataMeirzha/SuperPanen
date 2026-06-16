<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pra_panens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('kategori_tanaman');
            $table->string('nama_tanaman');
            $table->decimal('jumlah_bibit', 10, 2);
            $table->string('satuan_bibit');
            $table->date('tanggal_tanam');
            $table->string('musim');
            $table->string('kecamatan');
            $table->string('kabupaten');
            $table->decimal('luas_lahan_rekomendasi', 10, 2)->nullable();
            $table->decimal('estimasi_modal', 15, 2)->nullable();
            $table->decimal('biaya_sewa_alat', 15, 2)->default(0);
            $table->enum('status', ['aktif', 'selesai'])->default('aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pra_panens');
    }
};