<?php

namespace Database\Seeders;

use App\Models\Laporan;
use App\Models\User;
use App\Models\Kategori;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class LaporanSeeder extends Seeder
{
    public function run(): void
    {
        // Seeder Kategori
        $katInfrastruktur = Kategori::firstOrCreate(['nama' => 'Infrastruktur']);
        $katBencana = Kategori::firstOrCreate(['nama' => 'Bencana']);
        $katKebersihan = Kategori::firstOrCreate(['nama' => 'Kebersihan']);

        // Seeder User
        $user1 = User::firstOrCreate(
            ['email' => 'user1@example.com'],
            ['name' => 'Budi Santoso', 'password' => bcrypt('password'), 'role' => 'masyarakat', 'city' => 'Bandung']
        );
        $user2 = User::firstOrCreate(
            ['email' => 'user2@example.com'],
            ['name' => 'Siti Aminah', 'password' => bcrypt('password'), 'role' => 'masyarakat', 'city' => 'Bogor']
        );

        $admin = User::where('role', 'admin')->first();

        $laporans = [
            [
                'user_id' => $user1->id,
                'judul_laporan' => 'Kerusakan Jembatan di Jalan Sukarno-Hatta',
                'deskripsi' => 'Jembatan ambles dan berbahaya bagi pengendara.',
                'kategori_id' => $katInfrastruktur->id,
                'kecamatan' => 'Kec. Dayeuhkolot, Bandung',
                'status' => 'Terverifikasi',
                'urgensi' => 'Tinggi',
                'latitude' => -6.985,
                'longitude' => 107.632,
                'created_at' => Carbon::now()->subHours(5),
                'updated_at' => Carbon::now()->subHours(5),
                'admin_id' => $admin ? $admin->id : null,
                'waktu_verifikasi' => Carbon::now()->subHours(4),
            ],
            [
                'user_id' => $user2->id,
                'judul_laporan' => 'Tanah longsor menutup jalan raya',
                'deskripsi' => 'Hujan deras semalaman mengakibatkan tanah longsor.',
                'kategori_id' => $katBencana->id,
                'kecamatan' => 'Kec. Cisarua, Bogor',
                'status' => 'Darurat',
                'urgensi' => 'Tinggi',
                'latitude' => -6.671,
                'longitude' => 106.938,
                'created_at' => Carbon::now()->subHours(3),
                'updated_at' => Carbon::now()->subHours(3),
            ],
            [
                'user_id' => $user1->id,
                'judul_laporan' => 'Angin kencang merusak atap rumah',
                'deskripsi' => 'Puting beliung merusak 5 rumah warga.',
                'kategori_id' => $katBencana->id,
                'kecamatan' => 'Kec. Cimahi Tengah',
                'status' => 'Diproses',
                'urgensi' => 'Sedang',
                'latitude' => -6.873,
                'longitude' => 107.542,
                'created_at' => Carbon::now()->subHours(2),
                'updated_at' => Carbon::now()->subHours(1),
            ],
            [
                'user_id' => $user2->id,
                'judul_laporan' => 'Tumpukan sampah di pinggir jalan',
                'deskripsi' => 'Sampah sudah seminggu tidak diangkut.',
                'kategori_id' => $katKebersihan->id,
                'kecamatan' => 'Kec. Coblong, Bandung',
                'status' => 'Menunggu',
                'urgensi' => 'Rendah',
                'latitude' => -6.885,
                'longitude' => 107.613,
                'created_at' => Carbon::now()->subMinutes(30),
                'updated_at' => Carbon::now()->subMinutes(30),
            ],
            [
                'user_id' => $user1->id,
                'judul_laporan' => 'Pohon Tumbang menghalangi lalu lintas',
                'deskripsi' => 'Pohon besar tumbang di jalan utama.',
                'kategori_id' => $katInfrastruktur->id,
                'kecamatan' => 'Kec. Sumur Bandung, Bandung',
                'status' => 'Darurat',
                'urgensi' => 'Tinggi',
                'latitude' => -6.915,
                'longitude' => 107.610,
                'created_at' => Carbon::now()->subHours(1),
                'updated_at' => Carbon::now()->subHours(1),
            ],
            [
                'user_id' => $user2->id,
                'judul_laporan' => 'Lampu Jalan Mati',
                'deskripsi' => 'Membahayakan pengguna jalan saat malam.',
                'kategori_id' => $katInfrastruktur->id,
                'kecamatan' => 'Kec. Buahbatu, Bandung',
                'status' => 'Diproses',
                'urgensi' => 'Sedang',
                'latitude' => -6.945,
                'longitude' => 107.640,
                'created_at' => Carbon::now()->subDays(1),
                'updated_at' => Carbon::now()->subHours(12),
            ],
        ];

        foreach ($laporans as $laporan) {
            Laporan::create($laporan);
        }
    }
}
