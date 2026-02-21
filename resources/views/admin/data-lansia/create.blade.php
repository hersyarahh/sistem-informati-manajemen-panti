@extends('layouts.app-admin')

@section('title', 'Tambah Data Lansia')

@section('content')
<div class="w-full max-w-none space-y-6">

    <!-- Header -->
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-800">Tambah Data Lansia</h1>
        <a href="{{ route('admin.lansia.index') }}" class="text-blue-600 hover:text-blue-700 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    <!-- Error Messages -->
    @if ($errors->any())
    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-red-700 font-medium">Ada beberapa kesalahan:</p>
                <ul class="mt-2 text-sm text-red-600 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif

    <form action="{{ route('admin.lansia.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow">
        @csrf

        <!-- DATA PRIBADI LANSIA -->
        <div class="p-6 border-b">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Data Pribadi
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Masukkan nama lengkap">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">NIK <span class="text-red-500">*</span></label>
                    <input type="text" name="nik" value="{{ old('nik') }}" required maxlength="16"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="16 digit NIK">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Kartu Keluarga</label>
                    <input type="text" name="nomor_kk" value="{{ old('nomor_kk') }}"
                           maxlength="16"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Nomor KK">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin <span class="text-red-500">*</span></label>
                    <select name="jenis_kelamin" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Kota/Kabupaten kelahiran">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Lahir <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Agama</label>
                    <select name="agama"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">-- Pilih Agama --</option>
                        @php
                            $agamaOptions = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu', 'Lainnya'];
                        @endphp
                        @foreach ($agamaOptions as $option)
                            <option value="{{ $option }}" {{ old('agama') === $option ? 'selected' : '' }}>
                                {{ $option }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pendidikan Terakhir</label>
                    <select name="pendidikan_terakhir"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">-- Pilih Pendidikan --</option>
                        @php
                            $pendidikanOptions = ['Tidak Sekolah', 'SD', 'SMP', 'SMA/SMK', 'D1/D2/D3', 'S1', 'S2', 'S3', 'Lainnya'];
                        @endphp
                        @foreach ($pendidikanOptions as $option)
                            <option value="{{ $option }}" {{ old('pendidikan_terakhir') === $option ? 'selected' : '' }}>
                                {{ $option }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Daerah Asal</label>
                    <input type="text" name="daerah_asal" value="{{ old('daerah_asal') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Kota/Kabupaten asal">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Asal <span class="text-red-500">*</span></label>
                    <input type="text" name="alamat_asal" value="{{ old('alamat_asal') }}" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Alamat lengkap sebelum masuk panti">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Masuk <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_masuk" value="{{ old('tanggal_masuk') }}" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">No Kamar</label>
                    <input type="text" name="no_kamar" value="{{ old('no_kamar') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Contoh: A-101">
                </div>

            </div>
        </div>

        <!-- DOKUMEN PERSYARATAN -->
        <div class="p-6 border-b">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Dokumen Persyaratan
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Pas Foto -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        1. Pas Foto <span class="text-red-500">*</span>
                    </label>
                    <input type="file" name="foto" accept="image/*" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <p class="text-xs text-gray-500 mt-1">Format: JPG/PNG. Ukuran 3x4 cm (Max 2MB)</p>
                </div>

                <!-- KTP -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        2. KTP <span class="text-red-500">*</span>
                    </label>
                    <input type="file" name="dokumen_ktp" accept=".pdf,.jpg,.jpeg,.png" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <p class="text-xs text-gray-500 mt-1">Upload berkas KTP (PDF/JPG/PNG, Max 2MB)</p>
                </div>

                <!-- KK -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        3. Kartu Keluarga (KK) <span class="text-red-500">*</span>
                    </label>
                    <input type="file" name="dokumen_kk" accept=".pdf,.jpg,.jpeg,.png" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <p class="text-xs text-gray-500 mt-1">Upload berkas Kartu Keluarga (PDF/JPG/PNG, Max 2MB)</p>
                </div>

                <!-- BPJS -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        4. BPJS Kesehatan <span class="text-red-500">*</span>
                    </label>
                    <input type="file" name="dokumen_bpjs" accept=".pdf,.jpg,.jpeg,.png" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <p class="text-xs text-gray-500 mt-1">Upload berkas BPJS Kesehatan (PDF/JPG/PNG, Max 2MB)</p>
                </div>

                <!-- Surat Keterangan Terlantar -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        5. Surat Keterangan Terlantar dari Kelurahan/Dinas Sosial <span class="text-red-500">*</span>
                    </label>
                    <input type="file" name="dokumen_surat_terlantar" accept=".pdf" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <p class="text-xs text-gray-500 mt-1">Upload surat keterangan (PDF, Max 2MB)</p>
                </div>

                <!-- Surat Keterangan Sehat -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        6. Surat Keterangan Berbadan Sehat dari Dokter/Puskesmas <span class="text-red-500">*</span>
                    </label>
                    <input type="file" name="dokumen_surat_sehat" accept=".pdf" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <p class="text-xs text-gray-500 mt-1">Upload surat keterangan sehat (PDF, Max 2MB)</p>
                </div>

                <!-- Surat Pengantar -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        7. Surat Pengantar/Rekomendasi Masuk Panti dari Dinas Sosial Provinsi Riau <span class="text-red-500">*</span>
                    </label>
                    <input type="file" name="dokumen_surat_pengantar" accept=".pdf" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <p class="text-xs text-gray-500 mt-1">Upload surat pengantar (PDF, Max 2MB)</p>
                </div>
            </div>
        </div>

        <!-- KONTAK DARURAT -->
        <div class="p-6 border-b">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
                Kontak Darurat / Keluarga
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Keluarga / Wali
                    </label>
                    <input type="text" name="kontak_darurat_nama"
                           value="{{ old('kontak_darurat_nama') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Nama lengkap">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Nomor Telepon
                    </label>
                    <input type="text" name="kontak_darurat_telp"
                           value="{{ old('kontak_darurat_telp') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="08xxxxxxxxxx">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Hubungan
                    </label>
                    <input type="text" name="kontak_darurat_hubungan"
                           value="{{ old('kontak_darurat_hubungan') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Contoh: Anak, Cucu, Saudara">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Kontak Darurat</label>
                    <textarea name="kontak_darurat_alamat" rows="2"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Alamat lengkap keluarga/wali">{{ old('kontak_darurat_alamat') }}</textarea>
                </div>
            </div>
        </div>

        <!-- BUTTONS -->
        <div class="p-6 flex items-center justify-end gap-3">
            <a href="{{ route('admin.lansia.index') }}"
               class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                Batal
            </a>
            <button type="submit"
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Simpan Data
            </button>
        </div>
    </form>

</div>
@endsection
