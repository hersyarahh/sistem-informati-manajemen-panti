<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventaris;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; 



class InventarisController extends Controller
{
    private array $defaultKategori = [
        'Sarana/Prasarana',
        'Gedung',
        'Alat Bantu',
    ];

    private function kategoriOptions(): array
    {
        $fromTable = Inventaris::query()
            ->whereNotNull('kategori')
            ->where('kategori', '!=', '')
            ->distinct()
            ->orderBy('kategori')
            ->pluck('kategori')
            ->toArray();

        return array_values(array_unique(array_merge($this->defaultKategori, $fromTable)));
    }

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

    $inventaris = $query->latest()->paginate(6)->withQueryString();
    $kategoriOptions = $this->kategoriOptions();

    return view('admin.data-inventaris.index', compact('inventaris', 'kategoriOptions'));
}

    /**
     * Menampilkan form tambah inventaris
     */
    public function create()
    {
        $kategoriOptions = $this->kategoriOptions();
        return view('admin.data-inventaris.create', compact('kategoriOptions'));
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
            'keterangan'       => 'required|string',
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
        $kategoriOptions = $this->kategoriOptions();
        return view('admin.data-inventaris.edit', compact('inventaris', 'kategoriOptions'));
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
