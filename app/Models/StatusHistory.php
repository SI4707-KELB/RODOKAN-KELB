<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusHistory extends Model
{
    protected $fillable = [
        'laporan_id',
        'user_id',
        'status_sebelumnya',
        'status_baru',
        'catatan',
    ];
}
