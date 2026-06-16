<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role', 'no_hp', 'kecamatan', 'kabupaten', 'provinsi', 'is_active'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function praPanen() { return $this->hasMany(PraPanen::class); }
    public function pascaPanen() { return $this->hasMany(PascaPanen::class); }
    public function alatPertanian() { return $this->hasMany(AlatPertanian::class, 'mitra_id'); }
    public function permintaanSewa() { return $this->hasMany(PermintaanSewa::class); }
    public function laporan() { return $this->hasMany(Laporan::class, 'pengirim_id'); }
    public function notifikasi() { return $this->hasMany(Notifikasi::class); }

    public function isSuperAdmin() { return $this->role === 'superadmin'; }
    public function isAdminPanen() { return $this->role === 'admin_panen'; }
    public function isMitra() { return $this->role === 'mitra'; }
    public function isUser() { return $this->role === 'user'; }
}