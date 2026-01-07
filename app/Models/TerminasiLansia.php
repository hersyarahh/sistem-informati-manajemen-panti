<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TerminasiLansia extends Model
{
    protected $fillable = [
        'lansia_id',
        'tanggal_keluar',
        'jenis_terminasi',
        'lokasi_meninggal',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_keluar' => 'date',
    ];

    public function lansia()
    {
        return $this->belongsTo(Lansia::class);
    }
}
