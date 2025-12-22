<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalObat extends Model
{
    use HasFactory;

    protected $fillable = [
        'lansia_id',
        'nama_obat',
        'dosis',
        'frekuensi',
        'waktu_minum',
        'waktu_konsumsi',
        'tanggal_mulai',
        'tanggal_selesai',
        'catatan',
        'status',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'waktu_minum' => 'array',
    ];

    // Relationships
    public function lansia()
    {
        return $this->belongsTo(Lansia::class);
    }
}