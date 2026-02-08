<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventaris;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; 



class InventarisController extends Controller
{
    /**
     * Menampilkan data inventaris
     */
    public function index(Request $request)
{
    $query = Inventaris::query();

    // 🔍 Search nama barang
    if ($request->search) {
        $query->where('nama_barang', 'like', '%' . $request->search . '%');
    }

    // 💰 Filter sumber dana
    if ($request->sumber_dana) {
        $query->where('sumber_dana', $request->sumber_dana);
    }

    // 📦 Filter kategori 
    if ($request->kategori) {
        $query->where('kategori', $request->kategori);
    }

    $inventaris = $query->latest()->paginate(6);

    return view('admin.data-inventaris.index', compact('inventaris'));
}

    /**
     * Menampilkan form tambah inventaris
     */
    public function create()
    {
        return view('admin.data-inventaris.create');
    }

    /**
     * Menyimpan data inventaris baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_barang'      => 'required|string|max:255',
            'kategori'         => 'required|string',
            'jenis'            => 'required|string|max:255',
            'jumlah'           => 'required|integer|min:1',
            'kondisi'          => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'sumber_dana'      => 'required|in:APBD,Donatur,CSR',
            'tahun_pengadaan'  => 'required|integer|min:2000|max:' . date('Y'),
            'lokasi'           => 'required|string|max:255',
            'keterangan'       => 'nullable|string',
        ]);

        Inventaris::create($request->all());

        return redirect()
            ->route('admin.data-inventaris.index')
            ->with('success', 'Data inventaris berhasil ditambahkan');
    }

    /**
     * Menampilkan detail inventaris
     */
    public function show($id)
    {
        $inventaris = Inventaris::findOrFail($id);
        return view('admin.data-inventaris.detail', compact('inventaris'));
    }

    /**
     * Mendownload laporan inventaris dalam format PDF
     */
    public function downloadLaporan($id)
    {
        $inventaris = Inventaris::findOrFail($id);

        $pdf = Pdf::loadView(
            'admin.data-inventaris.laporan-pdf',
            compact('inventaris')
        );

        return $pdf->download(
            'Laporan_Inventaris_' . $inventaris->nama_barang . '.pdf'
        );
    }
    
    /**
     * Menampilkan form edit inventaris
     */
    public function edit(Inventaris $inventaris)
    {
        return view('admin.data-inventaris.edit', compact('inventaris'));
    }

    /**
     * Update data inventaris
     */
    public function update(Request $request, $id)
{
    $validated = $request->validate([
        'nama_barang'      => 'required|string|max:255',
        'kategori'         => 'required|string',
        'jenis'            => 'required|string|max:255',
        'jumlah'           => 'required|integer|min:1',
        'kondisi'          => 'required|in:Baik,Rusak Ringan,Rusak Berat',
        'sumber_dana'      => 'required|in:APBD,Donatur,CSR',
        'tahun_pengadaan'  => 'required|integer|min:2000|max:' . date('Y'),
        'lokasi'           => 'required|string|max:255',
        'keterangan'       => 'nullable|string',
    ]);

    Inventaris::findOrFail($id)->update($validated);

    return redirect()
        ->route('admin.data-inventaris.index')
        ->with('success', 'Data inventaris berhasil diperbarui');
}


    /**
     * Hapus data inventaris
     */
    public function destroy(Inventaris $inventaris)
{
    $inventaris->delete();

    return redirect()
        ->route('admin.data-inventaris.index')
        ->with('success', 'Data inventaris berhasil dihapus');
}
}
