@extends('layouts.app-admin')

@section('title', 'Terminasi Lansia')

@section('content')
<div class="bg-white p-6 rounded-lg shadow w-full max-w-lg mx-auto">

    <h2 class="text-xl font-bold mb-6">Form Terminasi Lansia</h2>

    <form action="{{ route('admin.lansia.terminasi.store', $lansia->id) }}" method="POST">
        @csrf

        <!-- Nama Lansia (readonly) -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Nama Lansia</label>
            <input type="text" value="{{ $lansia->nama_lengkap }}" readonly
                   class="w-full px-3 py-2 border rounded-lg bg-gray-100">
        </div>

        <!-- Tanggal Terminasi -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Tanggal Terminasi</label>
            <input type="date" name="tanggal_keluar" required
                   min="{{ $lansia->tanggal_masuk->format('Y-m-d') }}"
                   class="w-full px-3 py-2 border rounded-lg">
        </div>

        <!-- Status Terminasi (ikut status lansia saat ini jika sudah ada) -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Status Terminasi</label>
            <select name="jenis_terminasi" id="jenis_terminasi" required
                    class="w-full px-3 py-2 border rounded-lg">
                <option value="">Pilih Status</option>
                <option value="dipulangkan">Keluar / Dipulangkan</option>
                <option value="meninggal">Meninggal</option>
            </select>
        </div>

        <!-- Lokasi Meninggal (hanya muncul jika status meninggal) -->
        <div class="mb-4" id="lokasi_meninggal_wrapper" style="display:none;">
            <label class="block text-sm font-medium text-gray-700">Lokasi Meninggal</label>
            <select name="lokasi_meninggal" id="lokasi_meninggal"
                    class="w-full px-3 py-2 border rounded-lg">
                <option value="">Pilih Lokasi</option>
                <option value="panti">Panti</option>
                <option value="keluarga">Keluarga</option>
            </select>
        </div>

        <!-- Alasan / Keterangan -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Alasan / Keterangan</label>
            <textarea name="keterangan" rows="3"
                      class="w-full px-3 py-2 border rounded-lg"></textarea>
        </div>

        <div class="flex justify-end gap-2">
            <a href="{{ route('admin.lansia.index') }}"
               class="px-4 py-2 bg-gray-300 hover:bg-gray-400 rounded-lg">
               Batal
            </a>

            <button type="submit"
                    class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg">
                Simpan Terminasi
            </button>
        </div>
    </form>
</div>

<!-- Script untuk menampilkan lokasi meninggal jika status = meninggal -->
<script>
    const jenisTerminasi = document.getElementById('jenis_terminasi');
    const lokasiWrapper = document.getElementById('lokasi_meninggal_wrapper');

    jenisTerminasi.addEventListener('change', function() {
        if (this.value === 'meninggal') {
            lokasiWrapper.style.display = 'block';
            document.getElementById('lokasi_meninggal').required = true;
        } else {
            lokasiWrapper.style.display = 'none';
            document.getElementById('lokasi_meninggal').required = false;
        }
    });
</script>
@endsection
