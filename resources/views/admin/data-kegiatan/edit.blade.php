@extends('layouts.app-admin')

@section('title', 'Edit Kegiatan')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Edit Data Kegiatan</h1>
            <p class="text-sm text-gray-600 mt-1">
                Perbarui informasi kegiatan
            </p>
        </div>

        <a href="{{ route('admin.kegiatan.index') }}"
           class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
            ← Kembali
        </a>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.kegiatan.update', $kegiatan) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Nama Kegiatan -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Nama Kegiatan
                </label>
                <input type="text"
                       name="nama_kegiatan"
                       value="{{ old('nama_kegiatan', $kegiatan->nama_kegiatan) }}"
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                       required>
                @error('nama_kegiatan')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Jenis Kegiatan -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Jenis Kegiatan
                </label>
                <select name="jenis_kegiatan"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                        required>
                    <option value="">-- Pilih Jenis --</option>
                    @foreach(['Olahraga','Kesehatan','Keagamaan','Sosial','Hiburan'] as $jenis)
                        <option value="{{ $jenis }}"
                            {{ old('jenis_kegiatan', $kegiatan->jenis_kegiatan) == $jenis ? 'selected' : '' }}>
                            {{ $jenis }}
                        </option>
                    @endforeach
                </select>
                @error('jenis_kegiatan')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tanggal -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Tanggal
                </label>
                <input type="date"
                       name="tanggal"
                       value="{{ old('tanggal', $kegiatan->tanggal->format('Y-m-d')) }}"
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                       required>
                @error('tanggal')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Waktu -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Waktu Mulai
                    </label>
                    <input type="time"
                           name="waktu_mulai"
                           value="{{ old('waktu_mulai', $kegiatan->waktu_mulai) }}"
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                           required>
                    @error('waktu_mulai')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Waktu Selesai
                    </label>
                    <input type="time"
                           name="waktu_selesai"
                           value="{{ old('waktu_selesai', $kegiatan->waktu_selesai) }}"
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                           required>
                    @error('waktu_selesai')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Lokasi -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Lokasi
                </label>
                <input type="text"
                       name="lokasi"
                       value="{{ old('lokasi', $kegiatan->lokasi) }}"
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                       required>
                @error('lokasi')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Deskripsi -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Deskripsi
                </label>
                <textarea name="deskripsi"
                          rows="4"
                          class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">{{ old('deskripsi', $kegiatan->deskripsi) }}</textarea>
                @error('deskripsi')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Action -->
            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.kegiatan.show', $kegiatan) }}"
                   class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                    Batal
                </a>

                <button type="submit"
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    💾 Simpan Perubahan
                </button>
            </div>

        </form>
    </div>

</div>
@endsection
