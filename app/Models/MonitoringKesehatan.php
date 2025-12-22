<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonitoringKesehatan extends Model
{
    use HasFactory;

    protected $fillable = [
        'lansia_id',
        'tanggal_waktu',
        'tekanan_darah_sistolik',
        'tekanan_darah_diastolik',
        'berat_badan',
        'tinggi_badan',
        'suhu_tubuh',
        'denyut_nadi',
        'saturasi_oksigen',
        'gula_darah',
        'catatan',
        'petugas',
    ];

    protected $casts = [
        'tanggal_waktu' => 'datetime',
        'tekanan_darah_sistolik' => 'decimal:2',
        'tekanan_darah_diastolik' => 'decimal:2',
        'berat_badan' => 'decimal:2',
        'tinggi_badan' => 'decimal:2',
        'suhu_tubuh' => 'decimal:2',
        'gula_darah' => 'decimal:2',
    ];

    // Relationships
    public function lansia()
    {
        return $this->belongsTo(Lansia::class);
    }
}