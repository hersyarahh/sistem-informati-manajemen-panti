@extends('layouts.app-admin')

@section('title', 'Tambah Inventaris')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Tambah Inventaris</h1>
        <p class="text-sm text-gray-600 mt-1">Input data barang / aset inventaris</p>
    </div>

    <!-- Error Validation -->
    @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded">
            <ul class="text-sm text-red-700 list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form -->
    <form action="{{ route('admin.data-inventaris.store') }}"
          method="POST"
          class="bg-white rounded-lg shadow p-6 space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Nama Barang -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Barang</label>
                <input type="text" name="nama_barang"
                       value="{{ old('nama_barang') }}"
                       class="w-full px-4 py-2 border rounded-lg" required>
            </div>

            <!-- Kategori -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                <select name="kategori" class="w-full px-4 py-2 border rounded-lg" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($kategoriOptions as $kategori)
                        <option value="{{ $kategori }}" {{ old('kategori') == $kategori ? 'selected' : '' }}>
                            {{ $kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Jenis -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis</label>
                <input type="text" name="jenis"
                       value="{{ old('jenis') }}"
                       class="w-full px-4 py-2 border rounded-lg" required>
            </div>

            <!-- Jumlah -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah</label>
                <input type="number" name="jumlah" min="1"
                       value="{{ old('jumlah') }}"
                       class="w-full px-4 py-2 border rounded-lg" required>
            </div>

            <!-- Kondisi -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kondisi</label>
                <select name="kondisi" class="w-full px-4 py-2 border rounded-lg" required>
                    <option value="">-- Pilih Kondisi --</option>
                    <option value="Baik" {{ old('kondisi') == 'Baik' ? 'selected' : '' }}>Baik</option>
                    <option value="Rusak Ringan" {{ old('kondisi') == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                    <option value="Rusak Berat" {{ old('kondisi') == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                </select>
            </div>

            <!-- Sumber Dana -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Sumber Dana</label>
                <select name="sumber_dana" class="w-full px-4 py-2 border rounded-lg" required>
                    <option value="">-- Pilih Sumber Dana --</option>
                    <option value="APBD" {{ old('sumber_dana') == 'APBD' ? 'selected' : '' }}>APBD</option>
                    <option value="Donatur" {{ old('sumber_dana') == 'Donatur' ? 'selected' : '' }}>Donatur</option>
                    <option value="CSR" {{ old('sumber_dana') == 'CSR' ? 'selected' : '' }}>CSR</option>
                </select>
            </div>

            <!-- Tahun -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                <input type="number" name="tahun_pengadaan"
                       value="{{ old('tahun_pengadaan', date('Y')) }}"
                       class="w-full px-4 py-2 border rounded-lg" required>
            </div>

            <!-- Lokasi -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
                <input type="text" name="lokasi"
                       value="{{ old('lokasi') }}"
                       class="w-full px-4 py-2 border rounded-lg" required>
            </div>

        </div>

        <!-- Keterangan -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
            <textarea name="keterangan" rows="3"
                      class="w-full px-4 py-2 border rounded-lg">{{ old('keterangan') }}</textarea>
        </div>

        <!-- Button -->
        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.data-inventaris.index') }}"
               class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400">
                Kembali
            </a>
            <button type="submit"
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Simpan
            </button>
        </div>

    </form>
</div>
@endsection
