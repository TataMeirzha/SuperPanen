<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PraPanen extends Model
{
    protected $fillable = [
        'user_id', 'kategori_tanaman', 'nama_tanaman',
        'jumlah_bibit', 'satuan_bibit', 'tanggal_tanam',
        'musim', 'kecamatan', 'kabupaten',
        'luas_lahan_rekomendasi', 'estimasi_modal',
        'biaya_sewa_alat', 'status'
    ];

    public function user() { return $this->belongsTo(User::class); }
    public function pascaPanen() { return $this->hasOne(PascaPanen::class); }
    public function permintaanSewa() { return $this->hasMany(PermintaanSewa::class); }
}