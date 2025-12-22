<?php

namespace App\Exports;

use App\Models\Kegiatan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class KegiatanExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithTitle
{
    protected $bulan;
    protected $jenis;

    public function __construct($bulan = null, $jenis = null)
    {
        $this->bulan = $bulan ?? date('Y-m');
        $this->jenis = $jenis;
    }

    /**
     * Data untuk export
     */
    public function collection()
    {
        $query = Kegiatan::query()
            ->with('lansias')
            ->orderBy('tanggal', 'asc');

        // Filter Bulan
        $query->whereYear('tanggal', date('Y', strtotime($this->bulan)))
              ->whereMonth('tanggal', date('m', strtotime($this->bulan)));

        // Filter Jenis
        if ($this->jenis) {
            $query->where('jenis_kegiatan', $this->jenis);
        }

        $kegiatans = $query->get();
        $totalLansia = \App\Models\Lansia::count();

        return $kegiatans->map(function ($kegiatan, $index) use ($totalLansia) {
            $totalHadir = $kegiatan->lansias()
                ->wherePivot('status_kehadiran', 'hadir')
                ->count();
            
            $persentase = $totalLansia > 0 ? round(($totalHadir / $totalLansia) * 100, 1) : 0;

            return [
                'no' => $index + 1,
                'tanggal' => $kegiatan->tanggal->format('d-m-Y'),
                'nama_kegiatan' => $kegiatan->nama_kegiatan,
                'jenis_kegiatan' => $kegiatan->jenis_kegiatan,
                'total_hadir' => $totalHadir,
                'total_lansia' => $totalLansia,
                'persentase' => $persentase . '%',
            ];
        });
    }

    /**
     * Header kolom
     */
    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'Nama Kegiatan',
            'Jenis Kegiatan',
            'Total Hadir',
            'Total Lansia',
            'Persentase Hadir',
        ];
    }

    /**
     * Styling Excel
     */
    public function styles(Worksheet $sheet)
    {
        // Style untuk header
        $sheet->getStyle('A1:G1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 12,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4472C4'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);

        // Style untuk semua data
        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle("A2:G{$lastRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'CCCCCC'],
                ],
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Center align untuk kolom angka
        $sheet->getStyle("A2:A{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("E2:G{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Auto height untuk semua baris
        foreach (range(1, $lastRow) as $row) {
            $sheet->getRowDimension($row)->setRowHeight(-1);
        }

        return [];
    }

    /**
     * Lebar kolom
     */
    public function columnWidths(): array
    {
        return [
            'A' => 6,
            'B' => 15,
            'C' => 35,
            'D' => 18,
            'E' => 13,
            'F' => 13,
            'G' => 18,
        ];
    }

    /**
     * Nama sheet
     */
    public function title(): string
    {
        return 'Rekap ' . date('F Y', strtotime($this->bulan));
    }
}