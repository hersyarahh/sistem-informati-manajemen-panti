<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatKesehatan extends Model
{
    use HasFactory;

    protected $fillable = [
        'lansia_id',
        'tanggal_periksa',
        'jenis_pemeriksaan',
        'keluhan',
        'diagnosa',
        'tindakan',
        'resep_obat',
        'nama_dokter',
        'nama_petugas',
        'catatan',
        'file_hasil',
    ];

    protected $casts = [
        'tanggal_periksa' => 'date',
    ];

    // Relationships
    public function lansia()
    {
        return $this->belongsTo(Lansia::class);
    }
}