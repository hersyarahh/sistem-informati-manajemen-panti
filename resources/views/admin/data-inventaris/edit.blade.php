@extends('layouts.app-admin')

@section('title', 'Edit Inventaris')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Edit Inventaris</h1>
        <a href="{{ route('admin.data-inventaris.index') }}"
           class="px-4 py-2 text-sm bg-gray-100 hover:bg-gray-200 rounded">
            ← Kembali
        </a>
    </div>

    <!-- Card -->
    <div class="bg-white shadow rounded-lg p-6">

        <!-- Error Validation -->
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded">
                <ul class="text-sm text-red-600 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.data-inventaris.update', $inventaris->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Nama Barang -->
                <div>
                    <label class="block text-sm font-medium mb-1">Nama Barang</label>
                    <input type="text" name="nama_barang"
                           value="{{ old('nama_barang', $inventaris->nama_barang) }}"
                           class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200">
                </div>

                <!-- Kategori -->
                <div>
                    <label class="block text-sm font-medium mb-1">Kategori</label>
                    <select name="kategori"
                            class="w-full border rounded px-3 py-2">
                        <option value="">-- Pilih Kategori --</option>
                        <option value="Sarana/Prasarana" {{ old('kategori', $inventaris->kategori) == 'Sarana/Prasarana' ? 'selected' : '' }}>Sarana/Prasarana</option>
                        <option value="Alat Bantu" {{ old('kategori', $inventaris->kategori) == 'Alat Bantu' ? 'selected' : '' }}>Alat Bantu</option>
                        <option value="Gedung" {{ old('kategori', $inventaris->kategori) == 'Gedung' ? 'selected' : '' }}>Gedung</option>
                    </select>
                </div>

                <!-- Jenis -->
                <div>
                    <label class="block text-sm font-medium mb-1">Jenis</label>
                    <input type="text" name="jenis"
                           value="{{ old('jenis', $inventaris->jenis) }}"
                           class="w-full border rounded px-3 py-2">
                </div>

                <!-- Jumlah -->
                <div>
                    <label class="block text-sm font-medium mb-1">Jumlah</label>
                    <input type="number" name="jumlah"
                           value="{{ old('jumlah', $inventaris->jumlah) }}"
                           min="1"
                           class="w-full border rounded px-3 py-2">
                </div>

                <!-- Kondisi -->
                <div>
                    <label class="block text-sm font-medium mb-1">Kondisi</label>
                    <select name="kondisi"
                            class="w-full border rounded px-3 py-2">
                        <option value="Baik" {{ old('kondisi', $inventaris->kondisi) == 'Baik' ? 'selected' : '' }}>Baik</option>
                        <option value="Rusak Ringan" {{ old('kondisi', $inventaris->kondisi) == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                        <option value="Rusak Berat" {{ old('kondisi', $inventaris->kondisi) == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                    </select>
                </div>

                <!-- Sumber Dana -->
                <div>
                    <label class="block text-sm font-medium mb-1">Sumber Dana</label>
                    <select name="sumber_dana"
                            class="w-full border rounded px-3 py-2">
                        <option value="APBD" {{ old('sumber_dana', $inventaris->sumber_dana) == 'APBD' ? 'selected' : '' }}>APBD</option>
                        <option value="CSR" {{ old('sumber_dana', $inventaris->sumber_dana) == 'CSR' ? 'selected' : '' }}>CSR</option>
                        <option value="Donasi" {{ old('sumber_dana', $inventaris->sumber_dana) == 'Donasi' ? 'selected' : '' }}>Donasi</option>
                    </select>
                </div>

                <!-- Tahun -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Tahun 
                    </label>
                    <input type="number"
                        name="tahun_pengadaan"
                        value="{{ old('tahun_pengadaan', $inventaris->tahun_pengadaan) }}"
                        class="w-full px-4 py-2 border rounded-lg"
                        required>
                </div>

                <!-- Lokasi -->
                <div>
                    <label class="block text-sm font-medium mb-1">Lokasi</label>
                    <input type="text" name="lokasi"
                           value="{{ old('lokasi', $inventaris->lokasi) }}"
                           class="w-full border rounded px-3 py-2">
                </div>

            </div>

            <!-- Button -->
            <div class="flex justify-end mt-8 gap-3">
                <a href="{{ route('admin.data-inventaris.index') }}"
                   class="px-4 py-2 bg-gray-100 rounded hover:bg-gray-200">
                    Batal
                </a>
                <button type="submit"
                        class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Simpan Perubahan
                </button>
            </div>

        </form>
    </div>
</div>
@endsection
