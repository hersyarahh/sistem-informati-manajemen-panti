<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PekerjaSosial extends Model
{
    protected $fillable = [
        'nama_lengkap',
        'nik',
        'jenis_kelamin',
        'tanggal_lahir',
        'nomor_hp',
        'alamat',
        'pendidikan_terakhir',
        'status_pegawai',
        'tanggal_mulai_bertugas',
        'foto',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_mulai_bertugas' => 'date',
    ];
}
