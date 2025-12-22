@extends('layouts.app-admin')

@section('title', 'Edit Data Lansia')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <!-- Header -->
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-800">Edit Data Lansia</h1>
        <a href="{{ route('admin.lansia.index') }}"
           class="text-blue-600 hover:text-blue-700 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    <!-- Error -->
    @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded">
            <ul class="text-sm text-red-600 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.lansia.update', $lansia->id) }}"
          method="POST"
          enctype="multipart/form-data"
          class="bg-white rounded-lg shadow">

        @csrf
        @method('PUT')

        <!-- ================= DATA PRIBADI ================= -->
        <div class="p-6 border-b">
            <h2 class="text-lg font-semibold mb-4">Data Pribadi</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium mb-2">Nama Lengkap *</label>
                    <input type="text" name="nama_lengkap"
                           value="{{ old('nama_lengkap', $lansia->nama_lengkap) }}"
                           class="w-full px-4 py-2 border rounded-lg">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">NIK *</label>
                    <input type="text" name="nik"
                           value="{{ old('nik', $lansia->nik) }}"
                           class="w-full px-4 py-2 border rounded-lg">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Jenis Kelamin *</label>
                    <select name="jenis_kelamin" class="w-full px-4 py-2 border rounded-lg">
                        <option value="L" {{ $lansia->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ $lansia->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Tanggal Lahir *</label>
                    <input type="date" name="tanggal_lahir"
                           value="{{ optional($lansia->tanggal_lahir)->format('Y-m-d') }}"
                           class="w-full px-4 py-2 border rounded-lg">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Tanggal Masuk *</label>
                    <input type="date" name="tanggal_masuk"
                           value="{{ optional($lansia->tanggal_masuk)->format('Y-m-d') }}"
                           class="w-full px-4 py-2 border rounded-lg">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium mb-2">Alamat Asal *</label>
                    <textarea name="alamat_asal" rows="2"
                              class="w-full px-4 py-2 border rounded-lg">{{ $lansia->alamat_asal }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">No Kamar</label>
                    <input type="text" name="no_kamar"
                           value="{{ $lansia->no_kamar }}"
                           class="w-full px-4 py-2 border rounded-lg">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Foto Lansia</label>
                    @if($lansia->foto)
                        <img src="{{ asset('storage/'.$lansia->foto) }}"
                             class="w-24 h-24 object-cover rounded mb-2">
                    @endif
                    <input type="file" name="foto"
                           class="w-full px-4 py-2 border rounded-lg">
                </div>

            </div>
        </div>

        <!-- ================= DATA KESEHATAN ================= -->
        <div class="p-6 border-b">
            <h2 class="text-lg font-semibold mb-4">Data Kesehatan</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label class="block text-sm font-medium mb-2">Kondisi Kesehatan</label>
                    <select name="kondisi_kesehatan" class="w-full px-4 py-2 border rounded-lg">
                        <option value="sehat" {{ $lansia->kondisi_kesehatan == 'sehat' ? 'selected' : '' }}>Sehat</option>
                        <option value="sakit_ringan" {{ $lansia->kondisi_kesehatan == 'sakit_ringan' ? 'selected' : '' }}>Sakit Ringan</option>
                        <option value="sakit_berat" {{ $lansia->kondisi_kesehatan == 'sakit_berat' ? 'selected' : '' }}>Sakit Berat</option>
                        <option value="perawatan_khusus" {{ $lansia->kondisi_kesehatan == 'perawatan_khusus' ? 'selected' : '' }}>Perawatan Khusus</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Status</label>
                    <select name="status" class="w-full px-4 py-2 border rounded-lg">
                        <option value="aktif" {{ $lansia->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="keluar" {{ $lansia->status == 'keluar' ? 'selected' : '' }}>Keluar</option>
                        <option value="meninggal" {{ $lansia->status == 'meninggal' ? 'selected' : '' }}>Meninggal</option>
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium mb-2">Riwayat Penyakit</label>
                    <textarea name="riwayat_penyakit" rows="3"
                              class="w-full px-4 py-2 border rounded-lg">{{ $lansia->riwayat_penyakit }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium mb-2">Alergi</label>
                    <textarea name="alergi" rows="2"
                              class="w-full px-4 py-2 border rounded-lg">{{ $lansia->alergi }}</textarea>
                </div>

            </div>
        </div>

        <!-- ================= DOKUMEN ADMINISTRASI ================= -->
        <div class="p-6 border-b">
            <h2 class="text-lg font-semibold mb-4">Dokumen Administrasi</h2>

            @php
                $dokumen = [
                    'dokumen_ktp' => 'KTP',
                    'dokumen_kk' => 'Kartu Keluarga',
                    'dokumen_bpjs' => 'BPJS',
                    'dokumen_surat_pengantar' => 'Surat Pengantar',
                    'dokumen_surat_sehat' => 'Surat Sehat',
                    'dokumen_surat_terlantar' => 'Surat Terlantar',
                    'dokumen_surat_pernyataan_tinggal' => 'Surat Pernyataan Tinggal',
                    'dokumen_surat_terminasi' => 'Surat Terminasi',
                    'dokumen_berita_acara' => 'Berita Acara',
                ];
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($dokumen as $field => $label)
                    <div>
                        <label class="block text-sm font-medium mb-2">{{ $label }}</label>

                        @if(!empty($lansia->$field))
                            <a href="{{ asset('storage/'.$lansia->$field) }}"
                               target="_blank"
                               class="text-blue-600 text-sm block mb-1">
                                Lihat Dokumen
                            </a>
                        @endif

                        <input type="file" name="{{ $field }}"
                               class="w-full px-4 py-2 border rounded-lg">
                    </div>
                @endforeach
            </div>
        </div>

        <!-- BUTTON -->
        <div class="p-6 flex justify-end gap-3">
            <a href="{{ route('admin.lansia.index') }}"
               class="px-6 py-2 bg-gray-200 rounded-lg">Batal</a>
            <button type="submit"
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg">
                Update Data
            </button>
        </div>

    </form>
</div>
@endsection