@extends('layouts.app-admin')

@section('title', 'Tambah Kegiatan')

@section('content')
<form action="{{ route('admin.kegiatan.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow">
    @csrf

    <div class="mb-4">
        <label class="block font-medium">Nama Kegiatan</label>
        <input type="text" name="nama_kegiatan" class="w-full border rounded p-2" required>
    </div>

    <div class="mb-4">
        <label class="block font-medium">Jenis Kegiatan</label>
        <select name="jenis_kegiatan" class="w-full border rounded p-2" required>
            <option value="">-- Pilih Jenis --</option>
            <option value="Olahraga">Olahraga</option>
            <option value="Kesehatan">Kesehatan</option>
            <option value="Keagamaan">Keagamaan</option>
            <option value="Sosial">Sosial</option>
            <option value="Hiburan">Hiburan</option>
        </select>
    </div>

    <div class="mb-4">
        <label class="block font-medium">Tanggal</label>
        <input type="date" name="tanggal" class="w-full border rounded p-2" required>
    </div>

    <div class="mb-4 flex gap-4">
        <div class="w-1/2">
            <label class="block font-medium">Waktu Mulai</label>
            <input type="time" name="waktu_mulai" class="w-full border rounded p-2" required>
        </div>
        <div class="w-1/2">
            <label class="block font-medium">Waktu Selesai</label>
            <input type="time" name="waktu_selesai" class="w-full border rounded p-2" required>
        </div>
    </div>

    <div class="mb-4">
        <label class="block font-medium">Lokasi</label>
        <input type="text" name="lokasi" class="w-full border rounded p-2">
    </div>

    <div class="mb-4">
        <label class="block font-medium">Deskripsi</label>
        <textarea name="deskripsi" class="w-full border rounded p-2"></textarea>
    </div>

    <div class="flex gap-3">
    <a href="{{ route('admin.kegiatan.index') }}"
       class="px-4 py-2 bg-gray-400 text-white rounded">
        Kembali
    </a>

    <button type="submit"
        class="px-4 py-2 bg-blue-600 text-white rounded">
        Simpan
    </button>
</div>

</form>
@endsection
