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
use App\Models\Kehadiran;


class KegiatanController extends Controller
{
    // ======================
    // TAMPILKAN DATA
    // ======================
    public function index(Request $request)
    {
        $query = Kegiatan::query()->with([
            'kehadirans',
            'kehadiranHadir'
        ]);

        // Search nama kegiatan
        if ($request->filled('search')) {
            $query->where('nama_kegiatan', 'like', '%' . $request->search . '%');
        }

        // Filter jenis kegiatan
        if ($request->filled('jenis')) {
            $query->where('jenis_kegiatan', $request->jenis);
        }

        // Quick filter waktu
        if ($request->filter === 'hari_ini') {
            $query->whereDate('tanggal', Carbon::today());
        }

        if ($request->filter === 'minggu_ini') {
            $query->whereBetween('tanggal', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek(),
            ]);
        }

        if ($request->filter === 'bulan_ini') {
            $query->whereMonth('tanggal', Carbon::now()->month)
                ->whereYear('tanggal', Carbon::now()->year);
        }

        $kegiatans = $query
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
        $lansias = Lansia::orderBy('nama_lengkap')->get();

        $kehadiran = Kehadiran::where('kegiatan_id', $kegiatan->id)
            ->pluck('status_kehadiran', 'lansia_id')
            ->toArray();

        return view(
            'admin.data-kegiatan.kehadiran',
            compact('kegiatan', 'lansias', 'kehadiran')
        );
    }

    // ======================
    // SIMPAN KEHADIRAN
    // ======================
    public function storeKehadiran(Request $request, Kegiatan $kegiatan)
    {
        $request->validate([
            'kehadiran' => 'required|array'
        ]);

        foreach ($request->kehadiran as $lansia_id => $status) {
            Kehadiran::updateOrCreate(
                [
                    'kegiatan_id' => $kegiatan->id,
                    'lansia_id'   => $lansia_id,
                ],
                [
                    'status_kehadiran' => $status,
                    'catatan' => $request->catatan[$lansia_id] ?? null
                ]
            );
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
    // public function exportExcel(Request $request)
    // {
    //     $bulan = $request->bulan ?? date('Y-m');
    //     $jenis = $request->jenis;

    //     $fileName = 'Rekap_Kegiatan_' . date('F_Y', strtotime($bulan)) . '.xlsx';

    //     return Excel::download(
    //         new KegiatanExport($bulan, $jenis),
    //         $fileName
    //     );
    // }

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

    // ======================
    // DETAIL KEGIATAN
    // ======================
    public function show(Kegiatan $kegiatan)
    {
        // Load relasi agar efisien
        $kegiatan->load([
            'lansias',
            'kehadiranHadir'
        ]);

        // Statistik kehadiran
        $totalLansia = $kegiatan->lansias->count();

        $totalHadir = $kegiatan->lansias
            ->where('pivot.status_kehadiran', 'hadir')
            ->count();

        $totalTidakHadir = $totalLansia - $totalHadir;

        return view(
            'admin.data-kegiatan.show',
            compact(
                'kegiatan',
                'totalLansia',
                'totalHadir',
                'totalTidakHadir'
            )
        );
    }
}
