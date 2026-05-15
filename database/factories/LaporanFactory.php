<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Kategori;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Laporan>
 */
class LaporanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'judul_laporan' => $this->faker->sentence(5),
            'deskripsi' => $this->faker->paragraph(),
            'kategori_id' => Kategori::factory(),
            'kecamatan' => $this->faker->word(),
            'status' => $this->faker->randomElement(['Menunggu', 'Terverifikasi', 'Diproses', 'Ditindaklanjuti', 'Selesai', 'Ditolak']),
            'urgensi' => $this->faker->randomElement(['Rendah', 'Sedang', 'Tinggi', 'Darurat']),
            'latitude' => $this->faker->latitude(),
            'longitude' => $this->faker->longitude(),
            'foto' => null,
            'admin_id' => null,
            'catatan_verifikasi' => null,
            'alasan_penolakan' => null,
            'waktu_verifikasi' => null,
        ];
    }
}
