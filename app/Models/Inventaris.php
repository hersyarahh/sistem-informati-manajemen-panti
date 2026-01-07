<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventaris extends Model
{
    use HasFactory;

    /**
     * Nama tabel
     */
    protected $table = 'inventaris';

    /**
     * Primary key (default id, ditulis eksplisit biar jelas)
     */
    protected $primaryKey = 'id';

    /**
     * Mass assignment
     * Field yang boleh diisi dari form
     */
    protected $fillable = [
        'nama_barang',
        'kategori',
        'jenis',
        'jumlah',
        'kondisi',
        'sumber_dana',
        'tahun_pengadaan',
        'lokasi',
        'keterangan',
    ];

    /**
     * Cast tipe data (biar aman & konsisten)
     */
    protected $casts = [
        'jumlah' => 'integer',
        'tahun_pengadaan' => 'integer',
    ];

    /**
     * Scope filter pencarian (optional tapi rapi)
     * Bisa dipakai di controller
     */
    public function scopeFilter($query, $request)
    {
        if ($request->search) {
            $query->where('nama_barang', 'like', '%' . $request->search . '%');
        }

        if ($request->sumber_dana) {
            $query->where('sumber_dana', $request->sumber_dana);
        }

        if ($request->kategori) {
            $query->where('kategori', $request->kategori);
        }

        return $query;
    }
}
