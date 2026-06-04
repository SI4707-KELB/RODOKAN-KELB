<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    public function laporans()
    {
        return $this->hasMany(Laporan::class, 'kategori_id');
    }
}
