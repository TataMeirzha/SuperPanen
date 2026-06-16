<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlatPertanian extends Model
{
    protected $fillable = [
        'mitra_id', 'nama_alat', 'kategori', 'deskripsi',
        'harga_sewa_per_hari', 'stok', 'status',
        'kecamatan', 'kabupaten', 'provinsi', 'foto'
    ];

    public function mitra() { return $this->belongsTo(User::class, 'mitra_id'); }
    public function permintaanSewa() { return $this->hasMany(PermintaanSewa::class); }
}