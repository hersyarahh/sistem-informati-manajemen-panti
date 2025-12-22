<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use App\Models\Lansia;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\KegiatanExport;
use Barryvdh\DomPDF\Facade\Pdf;

class KegiatanController extends Controller
{
    // ======================
    // TAMPILKAN DATA
    // ======================
    public function index(Request $request)
    {
        $kegiatans = Kegiatan::with(['lansias', 'kehadiranHadir'])
            ->orderBy('tanggal', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.data-kegiatan.index', compact('kegiatans'));
    }

    // ======================
    // FORM TAMBAH
    // ======================
    public function create()
    {
        return view('admin.data-kegiatan.create');
    }

    // ======================
    // SIMPAN DATA
    // ======================
    public function store(Request $request)
    {
        $request->validate([
            'nama_kegiatan'   => 'required|string|max:255',
            'jenis_kegiatan'  => 'required|string|max:100',
            'tanggal'         => 'required|date',
            'waktu_mulai'     => 'required',
            'waktu_selesai'   => 'required',
            'lokasi'          => 'required|string|max:255',
            'deskripsi'       => 'nullable|string',
        ]);

        Kegiatan::create($request->all());

        return redirect()
            ->route('admin.kegiatan.index')
            ->with('success', 'Kegiatan berhasil ditambahkan');
    }

    // ======================
    // FORM EDIT
    // ======================
    public function edit(Kegiatan $kegiatan)
    {
        return view('admin.data-kegiatan.edit', compact('kegiatan'));
    }

    // ======================
    // UPDATE DATA
    // ======================
    public function update(Request $request, Kegiatan $kegiatan)
    {
        $request->validate([
            'nama_kegiatan'   => 'required|string|max:255',
            'jenis_kegiatan'  => 'required|string|max:100',
            'tanggal'         => 'required|date',
            'waktu_mulai'     => 'required',
            'waktu_selesai'   => 'required',
            'lokasi'          => 'required|string|max:255',
            'deskripsi'       => 'nullable|string',
        ]);

        $kegiatan->update($request->all());

        return redirect()
            ->route('admin.kegiatan.index')
            ->with('success', 'Kegiatan berhasil diperbarui');
    }

    // ======================
    // HAPUS
    // ======================
    public function destroy(Kegiatan $kegiatan)
    {
        $kegiatan->delete();

        return redirect()
            ->route('admin.kegiatan.index')
            ->with('success', 'Kegiatan berhasil dihapus');
    }

    // ======================
    // HALAMAN KEHADIRAN
    // ======================
    public function kehadiran(Kegiatan $kegiatan)
    {
        $lansias = Lansia::all();
        return view('admin.data-kegiatan.kehadiran', compact('kegiatan', 'lansias'));
    }

    // ======================
    // SIMPAN KEHADIRAN
    // ======================
    public function storeKehadiran(Request $request, Kegiatan $kegiatan)
    {
        foreach ($request->kehadiran as $lansia_id => $status) {
            $kegiatan->lansias()->syncWithoutDetaching([
                $lansia_id => [
                    'status_kehadiran' => $status,
                    'catatan' => $request->catatan[$lansia_id] ?? null
                ]
            ]);
        }

        return redirect()
            ->route('admin.kegiatan.index')
            ->with('success', 'Kehadiran berhasil disimpan');
    }

    // ======================
    // HALAMAN REKAP
    // ======================
    public function rekap(Request $request)
    {
        $query = Kegiatan::with('lansias')
            ->orderBy('tanggal', 'desc');

        // Filter bulan
        if ($request->filled('bulan')) {
            $query->whereYear('tanggal', date('Y', strtotime($request->bulan)))
                  ->whereMonth('tanggal', date('m', strtotime($request->bulan)));
        }

        // Filter jenis
        if ($request->filled('jenis')) {
            $query->where('jenis_kegiatan', $request->jenis);
        }

        $kegiatans = $query->get()->map(function ($kegiatan) {
            $kegiatan->total_hadir = $kegiatan->lansias()
                ->wherePivot('status_kehadiran', 'hadir')
                ->count();

            $kegiatan->total_lansia = Lansia::count();
            return $kegiatan;
        });

        return view('admin.data-kegiatan.rekap', compact('kegiatans'));
    }

    // ======================
    // EXPORT EXCEL
    // ======================
    public function exportExcel(Request $request)
    {
        $bulan = $request->bulan ?? date('Y-m');
        $jenis = $request->jenis;

        $fileName = 'Rekap_Kegiatan_' . date('F_Y', strtotime($bulan)) . '.xlsx';

        return Excel::download(
            new KegiatanExport($bulan, $jenis),
            $fileName
        );
    }

    // ======================
    // EXPORT PDF
    // ======================
    public function exportPdf(Request $request)
{
    $bulan = $request->bulan ?? date('Y-m');
    $jenis = $request->jenis;

    $query = Kegiatan::with('lansias');

    // Filter bulan
    if ($bulan) {
        $query->whereYear('tanggal', substr($bulan, 0, 4))
              ->whereMonth('tanggal', substr($bulan, 5, 2));
    }

    // Filter jenis
    if ($jenis) {
        $query->where('jenis_kegiatan', $jenis);
    }

    $kegiatans = $query->get()->map(function ($kegiatan) {
        $kegiatan->total_hadir = $kegiatan->lansias()
            ->wherePivot('status_kehadiran', 'hadir')
            ->count();

        $kegiatan->total_lansia = \App\Models\Lansia::count();
        return $kegiatan;
    });

    $totalKegiatan = $kegiatans->count();
    $totalHadir    = $kegiatans->sum('total_hadir');
    $rataRata      = $totalKegiatan > 0
        ? round($totalHadir / $totalKegiatan, 1)
        : 0;

    $pdf = Pdf::loadView(
        'admin.data-kegiatan.rekap-pdf',
        compact(
            'kegiatans',
            'bulan',
            'jenis',
            'totalKegiatan',
            'totalHadir',
            'rataRata'
        )
    );

    return $pdf->download('Rekap_Kegiatan.pdf');
}
}
