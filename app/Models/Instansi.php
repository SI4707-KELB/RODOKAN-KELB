<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instansi extends Model
{
    protected $fillable = [
        'nama',
        'alamat',
        'telepon',
        'email',
    ];

    public function laporans()
    {
        return $this->hasMany(Laporan::class);
    }
}
