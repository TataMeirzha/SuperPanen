<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $fillable = [
        'pengirim_id', 'judul', 'kategori',
        'deskripsi', 'status', 'balasan',
        'dibalas_oleh', 'dibalas_at'
    ];

    protected function casts(): array
    {
        return ['dibalas_at' => 'datetime'];
    }

    public function pengirim() { return $this->belongsTo(User::class, 'pengirim_id'); }
    public function pembalas() { return $this->belongsTo(User::class, 'dibalas_oleh'); }
}