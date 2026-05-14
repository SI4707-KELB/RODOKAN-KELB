<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValidasiLaporan extends Model
{
    use HasFactory;

    protected $table = 'validasi_laporans';

    protected $fillable = [
        'laporan_id',
        'admin_id',
        'deskripsi_lengkap',
        'foto_tersedia',
        'lokasi_gps',
        'lokasi_bandung',
        'kategori_sesuai',
        'tidak_duplikasi',
        'foto_relevan',
        'urgensi_sesuai',
        'total_passed',
        'total_items',
        'keterangan_validasi',
        'status_validasi',
    ];

    protected $casts = [
        'deskripsi_lengkap' => 'boolean',
        'foto_tersedia' => 'boolean',
        'lokasi_gps' => 'boolean',
        'lokasi_bandung' => 'boolean',
        'kategori_sesuai' => 'boolean',
        'tidak_duplikasi' => 'boolean',
        'foto_relevan' => 'boolean',
        'urgensi_sesuai' => 'boolean',
    ];

    public function laporan()
    {
        return $this->belongsTo(Laporan::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function getProgressPercentage()
    {
        return $this->total_items > 0 ? round(($this->total_passed / $this->total_items) * 100) : 0;
    }

    public function getValidationItems()
    {
        return [
            'deskripsi_lengkap' => 'Deskripsi laporan jelas dan lengkap',
            'foto_tersedia' => 'Foto bukti tersedia',
            'lokasi_gps' => 'Lokasi GPS tersedia',
            'lokasi_bandung' => 'Lokasi berada di Kota Bandung',
            'kategori_sesuai' => 'Kategori sesuai klasifikasi',
            'tidak_duplikasi' => 'Tidak ada duplikasi laporan',
            'foto_relevan' => 'Bukti foto relevan dengan laporan',
            'urgensi_sesuai' => 'Tingkat urgensi sesuai kondisi',
        ];
    }
}

