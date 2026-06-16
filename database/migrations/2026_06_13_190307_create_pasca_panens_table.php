<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pasca_panens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('pra_panen_id')->constrained('pra_panens')->onDelete('cascade');
            $table->date('tanggal_panen');
            $table->decimal('hasil_panen', 10, 2);
            $table->string('satuan_hasil');
            $table->decimal('modal_real', 15, 2);
            $table->decimal('harga_jual_per_kg', 15, 2);
            $table->decimal('total_pendapatan', 15, 2)->nullable();
            $table->decimal('keuntungan_bersih', 15, 2)->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pasca_panens');
    }
};