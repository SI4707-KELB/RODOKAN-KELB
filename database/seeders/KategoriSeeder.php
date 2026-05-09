<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoris = [
            ['id' => 1, 'nama' => 'Infrastruktur', 'deskripsi' => 'Keluhan terkait jalan, jembatan, bangunan umum, dll.', 'icon' => 'building'],
            ['id' => 2, 'nama' => 'Kebersihan', 'deskripsi' => 'Keluhan terkait sampah, saluran air mampet, lingkungan kotor, dll.', 'icon' => 'trash'],
            ['id' => 3, 'nama' => 'Keamanan', 'deskripsi' => 'Keluhan terkait kejahatan, ketertiban umum, dll.', 'icon' => 'shield'],
            ['id' => 4, 'nama' => 'Energi & Air', 'deskripsi' => 'Keluhan terkait listrik padam, air bersih mati, dll.', 'icon' => 'lightning'],
            ['id' => 5, 'nama' => 'Kesehatan', 'deskripsi' => 'Keluhan terkait fasilitas kesehatan, wabah penyakit, dll.', 'icon' => 'heart'],
            ['id' => 6, 'nama' => 'Lainnya', 'deskripsi' => 'Keluhan lainnya yang tidak termasuk dalam kategori di atas.', 'icon' => 'dots'],
        ];

        foreach ($kategoris as $kategori) {
            Kategori::updateOrCreate(['id' => $kategori['id']], $kategori);
        }
    }
}
