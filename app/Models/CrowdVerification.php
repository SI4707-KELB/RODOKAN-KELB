<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CrowdVerification extends Model
{
    protected $guarded = [];

    protected $casts = [
        'is_valid' => 'boolean',
    ];

    public function laporan()
    {
        return $this->belongsTo(Laporan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
