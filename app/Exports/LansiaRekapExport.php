<?php

namespace App\Exports;

use App\Models\Lansia;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LansiaRekapExport implements FromCollection, WithHeadings
{
    public function __construct(
        private readonly int $tahun,
        private readonly ?string $bulan = null,
        private readonly ?string $status = null
    ) {
    }

    public function collection(): Collection
    {
        $query = Lansia::with('terminasi')
            ->whereYear('tanggal_masuk', $this->tahun);

        if (!empty($this->bulan)) {
            $query->whereMonth('tanggal_masuk', $this->bulan);
        }

        if (!empty($this->status)) {
            $query->where('status', $this->status);
        }

        $lansias = $query->orderBy('tanggal_masuk', 'asc')->get();

        return $lansias->map(function (Lansia $lansia) {
            $suratTerminasi = $lansia->dokumen_surat_terminasi
                ? url('storage/' . $lansia->dokumen_surat_terminasi)
                : '';

            return [
                'nama_lengkap' => $lansia->nama_lengkap,
                'tanggal_lahir' => $lansia->tanggal_lahir?->format('d/m/Y') ?? '',
                'daerah_asal' => $lansia->daerah_asal ?? '',
                'alamat_asal' => $lansia->alamat_asal ?? '',
                'tanggal_masuk' => $lansia->tanggal_masuk?->format('d/m/Y') ?? '',
                'status' => $lansia->status,
                'tanggal_keluar' => $lansia->terminasi?->tanggal_keluar?->format('d/m/Y') ?? '',
                'keterangan' => $lansia->terminasi?->keterangan ?? '',
                'surat_terminasi' => $suratTerminasi,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nama',
            'Tanggal Lahir',
            'Daerah Asal',
            'Alamat Asal',
            'Tanggal Masuk',
            'Status',
            'Tanggal Keluar',
            'Keterangan',
            'Surat Terminasi',
        ];
    }
}
