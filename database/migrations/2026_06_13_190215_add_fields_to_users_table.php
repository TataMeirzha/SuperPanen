<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['superadmin', 'admin_panen', 'mitra', 'user'])->default('user')->after('email');
            $table->string('no_hp')->nullable()->after('role');
            $table->string('kecamatan')->nullable()->after('no_hp');
            $table->string('kabupaten')->nullable()->after('kecamatan');
            $table->string('provinsi')->nullable()->after('kabupaten');
            $table->boolean('is_active')->default(true)->after('provinsi');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'no_hp', 'kecamatan', 'kabupaten', 'provinsi', 'is_active']);
        });
    }
};