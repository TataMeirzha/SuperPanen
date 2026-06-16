<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    protected $fillable = [
        'user_id', 'judul', 'pesan', 'tipe', 'url', 'dibaca'
    ];

    protected function casts(): array
    {
        return ['dibaca' => 'boolean'];
    }

    public function user() { return $this->belongsTo(User::class); }
}