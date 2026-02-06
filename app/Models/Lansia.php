<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Lansia extends Model
{
    protected $fillable = [
        'nama_lengkap',
        'nik',
        'tempat_lahir',
        'jenis_kelamin',
        'tanggal_lahir',
        'agama',
        'nomor_kk',
        'pendidikan_terakhir',
        'tanggal_masuk',
        'alamat_asal',
        'daerah_asal',
        'no_kamar',
        'kondisi_kesehatan',
        'status',
        'riwayat_penyakit',
        'alergi',

        //STATUS
        'status',
        'status_sosial',

        //DOKUMEN ADMINISTRASI
        'dokumen_surat_pernyataan_tinggal',
        'dokumen_surat_terminasi',
        'dokumen_berita_acara',

        // KONTAK DARURAT
        'kontak_darurat_nama',
        'kontak_darurat_telp',
        'kontak_darurat_hubungan',
        'kontak_darurat_alamat',

        'foto',
        'dokumen_ktp',
        'dokumen_kk',
        'dokumen_bpjs',
        'dokumen_surat_terlantar',
        'dokumen_surat_sehat',
        'dokumen_surat_pengantar',

        'dokumen_surat_pernyataan_tinggal',
        'dokumen_surat_terminasi',
        'dokumen_berita_acara',

    ];

    /**
     * ⬇️ INI PENTING BANGET
     * Biar tanggal otomatis jadi Carbon
     */
    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_masuk' => 'date',
        'created_at'    => 'datetime',
        'updated_at'    => 'datetime',
    ];

    //MENGHITUNG KEHADIRAN LANSIA
    public function kehadirans()
    {
        return $this->hasMany(Kehadiran::class);
    }

    /**
     * Hitung umur lansia
     */
    public function umur()
    {
        return $this->tanggal_lahir
            ? $this->tanggal_lahir->age
            : null;
    }

    public function kegiatans()
    {
        return $this->belongsToMany(Kegiatan::class, 'kegiatan_lansia')
            ->withPivot('status_kehadiran', 'catatan')
            ->withTimestamps();
    }

    public function terminasi()
    {
        return $this->hasOne(TerminasiLansia::class);
    }

    public function karyawans()
    {
        return $this->belongsToMany(User::class, 'karyawan_lansia');
    }

    public function riwayatKesehatan()
    {
        return $this->hasMany(RiwayatKesehatan::class);
    }

    public function latestRiwayatKesehatan()
    {
        return $this->hasOne(RiwayatKesehatan::class)->latestOfMany('tanggal_periksa');
    }

    public function isAktif(): bool
    {
        return $this->terminasi === null;
    }

    public function isTerminasi()
    {
        return $this->terminasi()->exists();
    }
}
