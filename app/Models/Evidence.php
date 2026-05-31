<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evidence extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'evidences';

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function report()
    {
        return $this->belongsTo(Laporan::class, 'report_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
