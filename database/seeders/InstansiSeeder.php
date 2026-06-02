<?php

namespace Database\Seeders;

use App\Models\Instansi;
use Illuminate\Database\Seeder;

class InstansiSeeder extends Seeder
{
    public function run(): void
    {
        $instansis = [
            ['nama' => 'BPBD Kota Bandung', 'alamat' => 'Jl. Soekarno-Hatta No. 500, Bandung'],
            ['nama' => 'Dinas PUPR Kota Bandung', 'alamat' => 'Jl. Aceh No. 57, Bandung'],
            ['nama' => 'Dinas Lingkungan Hidup Kota Bandung', 'alamat' => 'Jl. Rancabentang No. 45, Bandung'],
            ['nama' => 'Dinas Sosial Kota Bandung', 'alamat' => 'Jl. Wastukencana No. 2, Bandung'],
            ['nama' => 'Satpol PP Kota Bandung', 'alamat' => 'Jl. Tamansari No. 57, Bandung'],
            ['nama' => 'Dinas Perhubungan Kota Bandung', 'alamat' => 'Jl. Cianjur No. 4, Bandung'],
            ['nama' => 'Dinas Kesehatan Kota Bandung', 'alamat' => 'Jl. Supratman No. 73, Bandung'],
            ['nama' => 'Dinas Pemadam Kebakaran Kota Bandung', 'alamat' => 'Jl. Merdeka No. 16, Bandung'],
            ['nama' => 'Dinas Perumahan dan Kawasan Permukiman', 'alamat' => 'Jl. Wastukencana No. 2, Bandung'],
            ['nama' => 'Dinas Ketahanan Pangan dan Pertanian', 'alamat' => 'Jl. Ir. H. Juanda No. 247, Bandung'],
        ];

        foreach ($instansis as $instansi) {
            Instansi::updateOrCreate(
                ['nama' => $instansi['nama']],
                $instansi
            );
        }
    }
}
