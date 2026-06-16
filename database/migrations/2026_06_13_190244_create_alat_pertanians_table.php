<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alat_pertanians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mitra_id')->constrained('users')->onDelete('cascade');
            $table->string('nama_alat');
            $table->string('kategori');
            $table->text('deskripsi')->nullable();
            $table->decimal('harga_sewa_per_hari', 15, 2);
            $table->integer('stok')->default(1);
            $table->enum('status', ['tersedia', 'disewa', 'perbaikan'])->default('tersedia');
            $table->string('kecamatan');
            $table->string('kabupaten');
            $table->string('provinsi');
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alat_pertanians');
    }
};