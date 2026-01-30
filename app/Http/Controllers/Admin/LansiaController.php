<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lansia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class LansiaController extends Controller
{
    // =========================
    // INDEX + FILTER + SEARCH
    // =========================
    public function index(Request $request)
    {
        $query = Lansia::query();

        if ($request->filled('search')) {
            $query->where('nama_lengkap', 'like', '%' . $request->search . '%');
        }

        $lansias = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.data-lansia.index', compact('lansias'));
    }

    // =========================
    // QUICK UPDATE STATUS
    // =========================
    public function updateStatus(Request $request, Lansia $lansia)
    {
        $request->validate([
            'status' => 'required|in:aktif,keluar,meninggal'
        ]);

        $lansia->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Status berhasil diperbarui!');
    }

    // =========================
    // FORM CREATE
    // =========================
    public function create()
    {
        return view('admin.data-lansia.create');
    }

    // =========================
    // SIMPAN DATA LANSIA
    // =========================
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'required|string|max:16|unique:lansias,nik',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date',
            'alamat_asal' => 'required|string',
            'no_kamar' => 'nullable|string|max:50',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            // 'status' => 'required|in:aktif,keluar,meninggal',
            'riwayat_penyakit' => 'nullable|string',
            'alergi' => 'nullable|string',
            'kontak_darurat_nama' => 'nullable|string|max:255',
            'kontak_darurat_telp' => 'nullable|string|max:20',
            'kontak_darurat_hubungan' => 'nullable|string|max:100',
            'kontak_darurat_alamat' => 'nullable|string',
            'status_sosial' => 'nullable|string|max:100',
            'dokumen_surat_pernyataan_tinggal' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'dokumen_surat_terminasi' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'dokumen_berita_acara' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'dokumen_ktp' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:2048',
            'dokumen_kk' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:2048',
            'dokumen_bpjs' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:2048',
            'dokumen_surat_terlantar' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'dokumen_surat_sehat' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'dokumen_surat_pengantar' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        // otomatis isi tanggal masuk
        $validated['tanggal_masuk'] = Carbon::now()->toDateString();

        // DAFTAR FILE YANG PERLU DISIMPAN
        $fileFields = [
            'foto',
            'dokumen_surat_pernyataan_tinggal',
            'dokumen_surat_terminasi',
            'dokumen_berita_acara',
            'dokumen_ktp',
            'dokumen_kk',
            'dokumen_bpjs',
            'dokumen_surat_terlantar',
            'dokumen_surat_sehat',
            'dokumen_surat_pengantar',
            'dokumen_berita_acara'
        ];

        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $validated[$field] = $request
                    ->file($field)
                    ->store('dokumen/lansia', 'public');
            }
        }

        Lansia::create($validated);

        return redirect()->route('admin.lansia.index')
            ->with('success', 'Data lansia berhasil ditambahkan!');
    }

    // =========================
    // DETAIL DATA
    // =========================
    public function show(Lansia $lansia)
    {
        return view('admin.data-lansia.show', compact('lansia'));
    }

    public function download(Lansia $lansia)
    {
        $pdf = Pdf::loadView('admin.data-lansia.pdf', compact('lansia'))
            ->setPaper('A4', 'portrait');

        return $pdf->download(
            'data-lansia-' . str_replace(' ', '-', strtolower($lansia->nama_lengkap)) . '.pdf'
        );
    }

    // =========================
    // FORM EDIT
    // =========================
    public function edit(Lansia $lansia)
    {
        return view('admin.data-lansia.edit', compact('lansia'));
    }

    // =========================
    // UPDATE DATA
    // =========================
    public function update(Request $request, Lansia $lansia)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'required|string|max:16|unique:lansias,nik,' . $lansia->id,
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date',
            'tanggal_masuk' => 'required|date',
            'alamat_asal' => 'required|string',
            'no_kamar' => 'nullable|string|max:50',

            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',

            'status' => 'required|in:aktif,keluar,meninggal',
            'riwayat_penyakit' => 'nullable|string',
            'alergi' => 'nullable|string',

            // KONTAK DARURAT
            'kontak_darurat_nama' => 'nullable|string|max:255',
            'kontak_darurat_telp' => 'nullable|string|max:20',
            'kontak_darurat_hubungan' => 'nullable|string|max:100',
            'kontak_darurat_alamat' => 'nullable|string',

            // DOKUMEN
            'dokumen_surat_pernyataan_tinggal' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'dokumen_surat_terminasi' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'dokumen_berita_acara' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'dokumen_ktp' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:2048',
            'dokumen_kk' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:2048',
            'dokumen_bpjs' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:2048',
            'dokumen_surat_terlantar' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'dokumen_surat_sehat' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'dokumen_surat_pengantar' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        /**
         * ================= FOTO =================
         */
        if ($request->hasFile('foto')) {
            if ($lansia->foto) {
                Storage::disk('public')->delete($lansia->foto);
            }

            $validated['foto'] = $request
                ->file('foto')
                ->store('lansia', 'public');
        }

        /**
         * ================= DOKUMEN =================
         */
        $documentFields = [
            'dokumen_surat_pernyataan_tinggal',
            'dokumen_surat_terminasi',
            'dokumen_berita_acara',
            'dokumen_ktp',
            'dokumen_kk',
            'dokumen_bpjs',
            'dokumen_surat_terlantar',
            'dokumen_surat_sehat',
            'dokumen_surat_pengantar',
        ];

        foreach ($documentFields as $field) {
            if ($request->hasFile($field)) {

                // hapus dokumen lama jika ada
                if ($lansia->$field) {
                    Storage::disk('public')->delete($lansia->$field);
                }

                // simpan dokumen baru
                $validated[$field] = $request
                    ->file($field)
                    ->store('dokumen/lansia', 'public');
            }
        }

        $lansia->update($validated);

        return redirect()
            ->route('admin.lansia.index')
            ->with('success', 'Data lansia berhasil diperbarui!');
    }

    // =========================
    // DELETE DATA
    // =========================
    public function destroy(Lansia $lansia)
    {
        if ($lansia->foto) {
            Storage::disk('public')->delete($lansia->foto);
        }

        $lansia->delete();

        return redirect()->route('admin.lansia.index')
            ->with('success', 'Data lansia berhasil dihapus!');
    }

    // ======================
    // REKAP DATA LANSIA
    // ======================
    public function rekap(Request $request)
    {
        $tahun  = $request->tahun ?? now()->year;
        $status = $request->status;

        // Load relasi terminasi
        $query = Lansia::with('terminasi');

        // Filter tahun masuk
        $query->whereYear('tanggal_masuk', $tahun);

        // Filter status
        if ($status) {
            if ($status == 'terminasi') {
                $query->whereHas('terminasi');
            } else {
                $query->where('status', $status);
            }
        }

        $lansias = $query->orderBy('tanggal_masuk', 'asc')->get();

        // Statistik ringkas
        $totalMasuk = $lansias->count();
        $totalAktif = $lansias->where('status', 'aktif')->count();
        $totalTerminasi = $lansias->whereNotNull('terminasi')->count();
        $totalMeninggal = $lansias->where('status', 'meninggal')->count();
        $meninggalPanti = $lansias->filter(function ($l) {
            return $l->terminasi && $l->terminasi->jenis_terminasi == 'meninggal' && $l->terminasi->lokasi_meninggal == 'panti';
        })->count();
        $dikembalikanKeluarga = $lansias->filter(function ($l) {
            return $l->terminasi && $l->terminasi->jenis_terminasi == 'dipulangkan' && $l->terminasi->lokasi_meninggal == 'keluarga';
        })->count();

        return view('admin.data-lansia.rekap', compact(
            'lansias',
            'tahun',
            'status',
            'totalMasuk',
            'totalAktif',
            'totalTerminasi',
            'totalMeninggal',
            'meninggalPanti',
            'dikembalikanKeluarga'
        ));
    }
}
