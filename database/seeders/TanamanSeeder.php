<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TanamanSeeder extends Seeder
{
    public function run(): void
    {
        // musim_rekomendasi: 'hujan' | 'kemarau' | 'pancaroba'
        // Catatan: ini rekomendasi umum berdasarkan pola tanam yang lazim di Indonesia,
        // bukan patokan mutlak. Kondisi lahan, irigasi, dan iklim mikro tiap daerah bisa berbeda.
        $tanaman = [
            ['kategori' => 'Tanaman Pangan', 'nama' => 'Padi', 'musim_rekomendasi' => 'hujan'],
            ['kategori' => 'Tanaman Pangan', 'nama' => 'Jagung', 'musim_rekomendasi' => 'kemarau'],
            ['kategori' => 'Tanaman Pangan', 'nama' => 'Kedelai', 'musim_rekomendasi' => 'kemarau'],
            ['kategori' => 'Tanaman Pangan', 'nama' => 'Kacang Tanah', 'musim_rekomendasi' => 'kemarau'],
            ['kategori' => 'Tanaman Pangan', 'nama' => 'Kacang Hijau', 'musim_rekomendasi' => 'kemarau'],
            ['kategori' => 'Tanaman Pangan', 'nama' => 'Ubi Kayu', 'musim_rekomendasi' => 'hujan'],
            ['kategori' => 'Tanaman Pangan', 'nama' => 'Ubi Jalar', 'musim_rekomendasi' => 'hujan'],
            ['kategori' => 'Tanaman Pangan', 'nama' => 'Sorgum', 'musim_rekomendasi' => 'kemarau'],

            ['kategori' => 'Sayuran', 'nama' => 'Bawang Merah', 'musim_rekomendasi' => 'kemarau'],
            ['kategori' => 'Sayuran', 'nama' => 'Bawang Putih', 'musim_rekomendasi' => 'kemarau'],
            ['kategori' => 'Sayuran', 'nama' => 'Bawang Daun', 'musim_rekomendasi' => 'pancaroba'],
            ['kategori' => 'Sayuran', 'nama' => 'Cabai Besar', 'musim_rekomendasi' => 'pancaroba'],
            ['kategori' => 'Sayuran', 'nama' => 'Cabai Rawit', 'musim_rekomendasi' => 'pancaroba'],
            ['kategori' => 'Sayuran', 'nama' => 'Tomat', 'musim_rekomendasi' => 'kemarau'],
            ['kategori' => 'Sayuran', 'nama' => 'Kentang', 'musim_rekomendasi' => 'pancaroba'],
            ['kategori' => 'Sayuran', 'nama' => 'Kubis', 'musim_rekomendasi' => 'pancaroba'],
            ['kategori' => 'Sayuran', 'nama' => 'Wortel', 'musim_rekomendasi' => 'pancaroba'],
            ['kategori' => 'Sayuran', 'nama' => 'Bayam', 'musim_rekomendasi' => 'pancaroba'],
            ['kategori' => 'Sayuran', 'nama' => 'Kangkung', 'musim_rekomendasi' => 'pancaroba'],
            ['kategori' => 'Sayuran', 'nama' => 'Terung', 'musim_rekomendasi' => 'pancaroba'],
            ['kategori' => 'Sayuran', 'nama' => 'Ketimun', 'musim_rekomendasi' => 'kemarau'],
            ['kategori' => 'Sayuran', 'nama' => 'Labu Siam', 'musim_rekomendasi' => 'hujan'],
            ['kategori' => 'Sayuran', 'nama' => 'Buncis', 'musim_rekomendasi' => 'pancaroba'],
            ['kategori' => 'Sayuran', 'nama' => 'Kacang Panjang', 'musim_rekomendasi' => 'pancaroba'],
            ['kategori' => 'Sayuran', 'nama' => 'Petsai/Sawi', 'musim_rekomendasi' => 'pancaroba'],

            ['kategori' => 'Buah-buahan', 'nama' => 'Mangga', 'musim_rekomendasi' => 'hujan'],
            ['kategori' => 'Buah-buahan', 'nama' => 'Pisang', 'musim_rekomendasi' => 'hujan'],
            ['kategori' => 'Buah-buahan', 'nama' => 'Durian', 'musim_rekomendasi' => 'hujan'],
            ['kategori' => 'Buah-buahan', 'nama' => 'Rambutan', 'musim_rekomendasi' => 'hujan'],
            ['kategori' => 'Buah-buahan', 'nama' => 'Jeruk Siam/Keprok', 'musim_rekomendasi' => 'hujan'],
            ['kategori' => 'Buah-buahan', 'nama' => 'Jeruk Pamelo', 'musim_rekomendasi' => 'hujan'],
            ['kategori' => 'Buah-buahan', 'nama' => 'Pepaya', 'musim_rekomendasi' => 'hujan'],
            ['kategori' => 'Buah-buahan', 'nama' => 'Nanas', 'musim_rekomendasi' => 'hujan'],
            ['kategori' => 'Buah-buahan', 'nama' => 'Semangka', 'musim_rekomendasi' => 'kemarau'],
            ['kategori' => 'Buah-buahan', 'nama' => 'Melon', 'musim_rekomendasi' => 'kemarau'],
            ['kategori' => 'Buah-buahan', 'nama' => 'Salak', 'musim_rekomendasi' => 'hujan'],
            ['kategori' => 'Buah-buahan', 'nama' => 'Jambu Biji', 'musim_rekomendasi' => 'hujan'],
            ['kategori' => 'Buah-buahan', 'nama' => 'Jambu Air', 'musim_rekomendasi' => 'hujan'],
            ['kategori' => 'Buah-buahan', 'nama' => 'Duku/Langsat/Kokosan', 'musim_rekomendasi' => 'hujan'],
            ['kategori' => 'Buah-buahan', 'nama' => 'Alpukat', 'musim_rekomendasi' => 'hujan'],
            ['kategori' => 'Buah-buahan', 'nama' => 'Belimbing', 'musim_rekomendasi' => 'hujan'],

            ['kategori' => 'Perkebunan', 'nama' => 'Kelapa Sawit', 'musim_rekomendasi' => 'hujan'],
            ['kategori' => 'Perkebunan', 'nama' => 'Karet', 'musim_rekomendasi' => 'hujan'],
            ['kategori' => 'Perkebunan', 'nama' => 'Kelapa', 'musim_rekomendasi' => 'hujan'],
            ['kategori' => 'Perkebunan', 'nama' => 'Kopi', 'musim_rekomendasi' => 'hujan'],
            ['kategori' => 'Perkebunan', 'nama' => 'Teh', 'musim_rekomendasi' => 'hujan'],
            ['kategori' => 'Perkebunan', 'nama' => 'Kakao', 'musim_rekomendasi' => 'hujan'],
            ['kategori' => 'Perkebunan', 'nama' => 'Tebu', 'musim_rekomendasi' => 'kemarau'],
            ['kategori' => 'Perkebunan', 'nama' => 'Tembakau', 'musim_rekomendasi' => 'kemarau'],
            ['kategori' => 'Perkebunan', 'nama' => 'Cengkeh', 'musim_rekomendasi' => 'hujan'],
            ['kategori' => 'Perkebunan', 'nama' => 'Lada', 'musim_rekomendasi' => 'hujan'],
        ];

        foreach ($tanaman as $item) {
            DB::table('tanamanlist')
                ->updateOrInsert(
                    ['kategori' => $item['kategori'], 'nama' => $item['nama']],
                    [
                        'musim_rekomendasi' => $item['musim_rekomendasi'],
                        'updated_at' => now(),
                        'created_at' => now(),
                    ]
                );
        }
    }
}