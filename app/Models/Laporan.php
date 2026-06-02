<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CrowdVerification;

class Laporan extends Model
{
    use HasFactory;

    protected $table = 'laporans';

    protected $fillable = [
        'user_id',
        'judul_laporan',
        'deskripsi',
        'kategori_id',
        'kecamatan',
        'alamat',
        'waktu_kejadian',
        'is_anonim',
        'status',
        'urgensi',
        'latitude',
        'longitude',
        'foto',
        'admin_id',
        'instansi_id',
        'catatan_verifikasi',
        'alasan_penolakan',
        'waktu_verifikasi',
    ];

    protected $casts = [
        'waktu_verifikasi' => 'datetime',
        'waktu_kejadian' => 'datetime',
        'is_anonim' => 'boolean',
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

    public function instansi()
    {
        return $this->belongsTo(Instansi::class);
    }

    public function komentars()
    {
        return $this->hasMany(Komentar::class);
    }

    public function statusHistories()
    {
        return $this->hasMany(StatusHistory::class);
    }

    public function upvotes()
    {
        return $this->hasMany(Upvote::class);
    }

    public function donasis()
    {
        return $this->hasMany(Donasi::class);
    }

    public function evidences()
    {
        return $this->hasMany(LaporanEvidence::class);
    }

    // New evidence layering relation (separate Evidence model)
    public function evidenceLayers()
    {
        return $this->hasMany(\App\Models\Evidence::class, 'report_id');
    }

    public function validasi()
    {
        return $this->hasOne(ValidasiLaporan::class);
    }

    public function crowdVerifications()
    {
        return $this->hasMany(CrowdVerification::class);
    }
}
