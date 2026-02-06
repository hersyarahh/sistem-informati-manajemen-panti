<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kehadiran extends Model
{
    protected $fillable = [
        'kegiatan_id',
        'lansia_id',
        'status_kehadiran', 
        'catatan',
        'pembatalan_diajukan_at',
        'pembatalan_alasan',
    ];

    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class);
    }

    public function lansia()
    {
        return $this->belongsTo(Lansia::class);
    }
}
