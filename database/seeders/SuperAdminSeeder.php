<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@superpanen.com',
            'password' => Hash::make('superadmin123'),
            'role' => 'superadmin',
            'no_hp' => '08000000000',
            'kecamatan' => 'Pusat',
            'kabupaten' => 'Pusat',
            'provinsi' => 'Pusat',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Admin Panen',
            'email' => 'adminpanen@superpanen.com',
            'password' => Hash::make('adminpanen123'),
            'role' => 'admin_panen',
            'no_hp' => '08000000001',
            'kecamatan' => 'Pusat',
            'kabupaten' => 'Pusat',
            'provinsi' => 'Pusat',
            'is_active' => true,
        ]);
    }
}