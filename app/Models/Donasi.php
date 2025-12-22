<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_donatur',
        'email',
        'no_telp',
        'jenis_donasi',
        'nominal',
        'deskripsi_barang',
        'tanggal_donasi',
        'status',
        'catatan',
        'bukti_donasi',
    ];

    protected $casts = [
        'tanggal_donasi' => 'date',
        'nominal' => 'decimal:2',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}