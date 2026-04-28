@extends('layouts.app-admin')

@section('title', 'Terminasi Lansia')

@section('content')
<div class="bg-white p-6 rounded-lg shadow w-full max-w-lg mx-auto">

    <h2 class="text-xl font-bold mb-6">Form Terminasi Lansia</h2>

    @if ($errors->any())
        <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.lansia.terminasi.store', $lansia->id) }}" method="POST" enctype="multipart/form-data">
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
                   value="{{ old('tanggal_keluar') }}"
                   min="{{ $lansia->tanggal_masuk->format('Y-m-d') }}"
                   class="w-full px-3 py-2 border rounded-lg">
        </div>

        <!-- Status Terminasi (ikut status lansia saat ini jika sudah ada) -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Status Terminasi</label>
            <select name="jenis_terminasi" id="jenis_terminasi" required
                    class="w-full px-3 py-2 border rounded-lg">
                <option value="">Pilih Status</option>
                <option value="dipulangkan" {{ old('jenis_terminasi') === 'dipulangkan' ? 'selected' : '' }}>Keluar / Dipulangkan</option>
                <option value="meninggal" {{ old('jenis_terminasi') === 'meninggal' ? 'selected' : '' }}>Meninggal</option>
            </select>
        </div>

        <!-- Alasan / Keterangan -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Alasan / Keterangan <span class="text-red-500">*</span></label>
            <textarea name="keterangan" rows="3" required
                      class="w-full px-3 py-2 border rounded-lg">{{ old('keterangan') }}</textarea>
        </div>

        <!-- Surat Terminasi -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Surat Terminasi <span class="text-red-500">*</span></label>
            <input type="file" name="dokumen_surat_terminasi" accept=".pdf,.jpg,.jpeg,.png" required
                   class="w-full px-3 py-2 border rounded-lg">
            <p class="text-xs text-gray-500 mt-1">Upload surat terminasi (PDF/JPG/PNG, Max 2MB)</p>
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

<script>
    // Tidak ada field lokasi meninggal di form terminasi.
</script>
@endsection
