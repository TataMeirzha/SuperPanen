<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TanamanSeeder extends Seeder
{
    public function run(): void
    {
        $tanaman = [
            // Tanaman Pangan (sesuai Statistik Tanaman Pangan BPS)
            ['kategori' => 'Tanaman Pangan', 'nama' => 'Padi'],
            ['kategori' => 'Tanaman Pangan', 'nama' => 'Jagung'],
            ['kategori' => 'Tanaman Pangan', 'nama' => 'Kedelai'],
            ['kategori' => 'Tanaman Pangan', 'nama' => 'Kacang Tanah'],
            ['kategori' => 'Tanaman Pangan', 'nama' => 'Kacang Hijau'],
            ['kategori' => 'Tanaman Pangan', 'nama' => 'Ubi Kayu'],
            ['kategori' => 'Tanaman Pangan', 'nama' => 'Ubi Jalar'],
            ['kategori' => 'Tanaman Pangan', 'nama' => 'Sorgum'],

            // Sayuran (sesuai Statistik Hortikultura BPS)
            ['kategori' => 'Sayuran', 'nama' => 'Bawang Merah'],
            ['kategori' => 'Sayuran', 'nama' => 'Bawang Putih'],
            ['kategori' => 'Sayuran', 'nama' => 'Bawang Daun'],
            ['kategori' => 'Sayuran', 'nama' => 'Cabai Besar'],
            ['kategori' => 'Sayuran', 'nama' => 'Cabai Rawit'],
            ['kategori' => 'Sayuran', 'nama' => 'Tomat'],
            ['kategori' => 'Sayuran', 'nama' => 'Kentang'],
            ['kategori' => 'Sayuran', 'nama' => 'Kubis'],
            ['kategori' => 'Sayuran', 'nama' => 'Wortel'],
            ['kategori' => 'Sayuran', 'nama' => 'Bayam'],
            ['kategori' => 'Sayuran', 'nama' => 'Kangkung'],
            ['kategori' => 'Sayuran', 'nama' => 'Terung'],
            ['kategori' => 'Sayuran', 'nama' => 'Ketimun'],
            ['kategori' => 'Sayuran', 'nama' => 'Labu Siam'],
            ['kategori' => 'Sayuran', 'nama' => 'Buncis'],
            ['kategori' => 'Sayuran', 'nama' => 'Kacang Panjang'],
            ['kategori' => 'Sayuran', 'nama' => 'Petsai/Sawi'],

            // Buah-buahan (sesuai Statistik Hortikultura BPS)
            ['kategori' => 'Buah-buahan', 'nama' => 'Mangga'],
            ['kategori' => 'Buah-buahan', 'nama' => 'Pisang'],
            ['kategori' => 'Buah-buahan', 'nama' => 'Durian'],
            ['kategori' => 'Buah-buahan', 'nama' => 'Rambutan'],
            ['kategori' => 'Buah-buahan', 'nama' => 'Jeruk Siam/Keprok'],
            ['kategori' => 'Buah-buahan', 'nama' => 'Jeruk Pamelo'],
            ['kategori' => 'Buah-buahan', 'nama' => 'Pepaya'],
            ['kategori' => 'Buah-buahan', 'nama' => 'Nanas'],
            ['kategori' => 'Buah-buahan', 'nama' => 'Semangka'],
            ['kategori' => 'Buah-buahan', 'nama' => 'Melon'],
            ['kategori' => 'Buah-buahan', 'nama' => 'Salak'],
            ['kategori' => 'Buah-buahan', 'nama' => 'Jambu Biji'],
            ['kategori' => 'Buah-buahan', 'nama' => 'Jambu Air'],
            ['kategori' => 'Buah-buahan', 'nama' => 'Duku/Langsat/Kokosan'],
            ['kategori' => 'Buah-buahan', 'nama' => 'Alpukat'],
            ['kategori' => 'Buah-buahan', 'nama' => 'Belimbing'],

            // Perkebunan (komoditas perkebunan rakyat sesuai BPS)
            ['kategori' => 'Perkebunan', 'nama' => 'Kelapa Sawit'],
            ['kategori' => 'Perkebunan', 'nama' => 'Karet'],
            ['kategori' => 'Perkebunan', 'nama' => 'Kelapa'],
            ['kategori' => 'Perkebunan', 'nama' => 'Kopi'],
            ['kategori' => 'Perkebunan', 'nama' => 'Teh'],
            ['kategori' => 'Perkebunan', 'nama' => 'Kakao'],
            ['kategori' => 'Perkebunan', 'nama' => 'Tebu'],
            ['kategori' => 'Perkebunan', 'nama' => 'Tembakau'],
            ['kategori' => 'Perkebunan', 'nama' => 'Cengkeh'],
            ['kategori' => 'Perkebunan', 'nama' => 'Lada'],
        ];

        foreach ($tanaman as $item) {
            DB::table('tanamanlist')->insert([
                'kategori' => $item['kategori'],
                'nama' => $item['nama'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}