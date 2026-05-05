<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    protected $table = 'laporans';

    protected $fillable = [
        'user_id',
        'judul_laporan',
        'deskripsi',
        'kategori',
        'kecamatan',
        'status',
        'urgensi',
        'latitude',
        'longitude',
        'foto',
        'admin_id',
        'catatan_verifikasi',
        'alasan_penolakan',
        'waktu_verifikasi',
    ];

    protected $casts = [
        'waktu_verifikasi' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
