<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kegiatan',
        'jenis_kegiatan',
        'tanggal',
        'waktu_mulai',
        'waktu_selesai',
        'lokasi',
        'deskripsi',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    /**
     * SEMUA DATA KEHADIRAN 
     */
    public function kehadirans()
    {
        return $this->hasMany(Kehadiran::class, 'kegiatan_id');
    }

    /**
     * YANG HADIR SAJA
     */
    public function kehadiranHadir()
    {
        return $this->hasMany(Kehadiran::class, 'kegiatan_id')
            ->where('status_kehadiran', 'hadir');
    }

    /**
     * RELASI KE LANSIA 
     */
    public function lansias()
    {
        return $this->belongsToMany(Lansia::class, 'kehadirans', 'kegiatan_id', 'lansia_id')
            ->withPivot('status_kehadiran', 'catatan')
            ->withTimestamps();
    }
}
