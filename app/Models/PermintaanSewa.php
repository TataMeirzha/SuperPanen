<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermintaanSewa extends Model
{
    protected $fillable = [
        'user_id', 'alat_pertanian_id', 'pra_panen_id',
        'tanggal_mulai', 'tanggal_selesai', 'durasi_hari',
        'total_biaya', 'status', 'catatan_user', 'catatan_mitra'
    ];

    public function user() { return $this->belongsTo(User::class); }
    public function alatPertanian() { return $this->belongsTo(AlatPertanian::class); }
    public function praPanen() { return $this->belongsTo(PraPanen::class); }
}