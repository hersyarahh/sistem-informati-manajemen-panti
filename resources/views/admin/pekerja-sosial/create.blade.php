@extends('layouts.app-admin')

@section('title', 'Tambah Pekerja Sosial')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-800">Tambah Pekerja Sosial</h1>
        <a href="{{ route('admin.pekerja-sosial.index') }}"
           class="text-blue-600 hover:text-blue-700">Kembali</a>
    </div>

    @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded">
            <ul class="text-sm text-red-600 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.pekerja-sosial.store') }}"
          method="POST"
          enctype="multipart/form-data"
          class="bg-white rounded-lg shadow p-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-2">Nama lengkap</label>
                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}"
                       class="w-full px-4 py-3 border rounded-lg">
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">NIP</label>
                <input type="text" name="nik" value="{{ old('nik') }}" maxlength="18" minlength="18" inputmode="numeric" pattern="[0-9]*"
                       class="w-full px-4 py-3 border rounded-lg">
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">Jenis kelamin</label>
                <select name="jenis_kelamin" class="w-full px-4 py-3 border rounded-lg">
                    <option value="">-- Pilih --</option>
                    <option value="L" {{ old('jenis_kelamin') === 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('jenis_kelamin') === 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">Tanggal lahir</label>
                <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                       class="w-full px-4 py-3 border rounded-lg">
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">Nomor HP</label>
                <input type="text" name="nomor_hp" value="{{ old('nomor_hp') }}"
                       class="w-full px-4 py-3 border rounded-lg">
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">Alamat</label>
                <input type="text" name="alamat" value="{{ old('alamat') }}"
                       class="w-full px-4 py-3 border rounded-lg">
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">Pendidikan terakhir</label>
                <select name="pendidikan_terakhir" class="w-full px-4 py-3 border rounded-lg">
                    <option value="">-- Pilih --</option>
                    <option value="SD" {{ old('pendidikan_terakhir') === 'SD' ? 'selected' : '' }}>SD</option>
                    <option value="SMP" {{ old('pendidikan_terakhir') === 'SMP' ? 'selected' : '' }}>SMP</option>
                    <option value="SMA/SMK" {{ old('pendidikan_terakhir') === 'SMA/SMK' ? 'selected' : '' }}>SMA/SMK</option>
                    <option value="D1/D2/D3" {{ old('pendidikan_terakhir') === 'D1/D2/D3' ? 'selected' : '' }}>D1/D2/D3</option>
                    <option value="S1" {{ old('pendidikan_terakhir') === 'S1' ? 'selected' : '' }}>S1</option>
                    <option value="S2" {{ old('pendidikan_terakhir') === 'S2' ? 'selected' : '' }}>S2</option>
                    <option value="S3" {{ old('pendidikan_terakhir') === 'S3' ? 'selected' : '' }}>S3</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">Status pegawai</label>
                <select name="status_pegawai" class="w-full px-4 py-3 border rounded-lg">
                    <option value="">-- Pilih --</option>
                    <option value="Tetap" {{ old('status_pegawai') === 'Tetap' ? 'selected' : '' }}>Tetap</option>
                    <option value="Honorer" {{ old('status_pegawai') === 'Honorer' ? 'selected' : '' }}>Honorer</option>
                    <option value="Kontrak" {{ old('status_pegawai') === 'Kontrak' ? 'selected' : '' }}>Kontrak</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">Tanggal mulai bertugas</label>
                <input type="date" name="tanggal_mulai_bertugas" value="{{ old('tanggal_mulai_bertugas') }}"
                       class="w-full px-4 py-3 border rounded-lg">
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">Foto</label>
                <input type="file" name="foto" accept=".jpg,.jpeg,.png"
                       class="w-full px-4 py-3 border rounded-lg">
            </div>
        </div>

        <div class="mt-6 flex justify-end gap-3">
            <a href="{{ route('admin.pekerja-sosial.index') }}"
               class="px-6 py-2 bg-gray-200 rounded-lg">Batal</a>
            <button type="submit"
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection
