<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kunjungan extends Model
{
    use HasFactory;

    protected $fillable = [
        'lansia_id',
        'user_id',
        'nama_pengunjung',
        'hubungan',
        'tanggal_kunjungan',
        'waktu_mulai',
        'waktu_selesai',
        'keperluan',
        'status',
        'catatan',
    ];

    protected $casts = [
        'tanggal_kunjungan' => 'date',
    ];

    // Relationships
    public function lansia()
    {
        return $this->belongsTo(Lansia::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}