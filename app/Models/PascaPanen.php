<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PascaPanen extends Model
{
    protected $fillable = [
        'user_id', 'pra_panen_id', 'tanggal_panen',
        'hasil_panen', 'satuan_hasil', 'modal_real',
        'harga_jual_per_kg', 'total_pendapatan',
        'keuntungan_bersih', 'catatan'
    ];

    public function user() { return $this->belongsTo(User::class); }
    public function praPanen() { return $this->belongsTo(PraPanen::class); }
}