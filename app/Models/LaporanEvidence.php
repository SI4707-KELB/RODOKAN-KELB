<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanEvidence extends Model
{
    protected $guarded = [];

    protected $table = 'laporan_evidence';

    public function laporan()
    {
        return $this->belongsTo(Laporan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
