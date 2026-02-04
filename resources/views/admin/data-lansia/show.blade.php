@extends('layouts.app-admin')

@section('title', 'Detail Lansia')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Detail Data Lansia</h1>
            <p class="text-gray-600 text-sm mt-1">Informasi lengkap lansia</p>
        </div>

        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.lansia.download', $lansia) }}"
               class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">
                Download PDF
            </a>

            <a href="{{ route('admin.lansia.edit', $lansia) }}"
               class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 text-sm">
                Edit
            </a>

            <a href="{{ route('admin.lansia.index') }}"
               class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 text-sm">
                Kembali
            </a>
        </div>
    </div>

    <!-- Card Utama -->
    <div class="bg-white rounded-lg shadow p-6">

        <!-- Profil -->
        <div class="flex flex-col md:flex-row gap-6 items-start">

            <!-- Foto -->
            <div class="w-32 h-32 flex-shrink-0">
                @if(!empty($lansia->foto))
                    <img src="{{ asset('storage/' . $lansia->foto) }}"
                         class="w-32 h-32 rounded-full object-cover border">
                @else
                    <div class="w-32 h-32 rounded-full bg-blue-100 flex items-center justify-center">
                        <span class="text-4xl font-bold text-blue-600">
                            {{ substr($lansia->nama_lengkap, 0, 1) }}
                        </span>
                    </div>
                @endif
            </div>

            <!-- Info Utama -->
            <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-500">Nama Lengkap</p>
                    <p class="font-semibold">{{ $lansia->nama_lengkap }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">NIK</p>
                    <p class="font-semibold">{{ $lansia->nik }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Nomor Kartu Keluarga</p>
                    <p class="font-semibold">{{ $lansia->nomor_kk ?? '-' }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Jenis Kelamin</p>
                    <p class="font-semibold">
                        {{ $lansia->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Tempat Lahir</p>
                    <p class="font-semibold">{{ $lansia->tempat_lahir ?? '-' }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Tanggal Lahir</p>
                    <p class="font-semibold">
                        {{ $lansia->tanggal_lahir->format('d/m/Y') }}
                        @if ($lansia->umur())
                            ({{ $lansia->umur() }} tahun)
                        @endif
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Agama</p>
                    <p class="font-semibold">{{ $lansia->agama ?? '-' }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Pendidikan Terakhir</p>
                    <p class="font-semibold">{{ $lansia->pendidikan_terakhir ?? '-' }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Daerah Asal</p>
                    <p class="font-semibold">{{ $lansia->daerah_asal ?? '-' }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Alamat Asal</p>
                    <p class="font-semibold">{{ $lansia->alamat_asal }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Tanggal Masuk</p>
                    <p class="font-semibold">
                        {{ \Carbon\Carbon::parse($lansia->tanggal_masuk)->format('d/m/Y') }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">No. Kamar</p>
                    <p class="font-semibold">{{ $lansia->no_kamar ?? '-' }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Status</p>
                    <p class="font-semibold capitalize">{{ $lansia->status }}</p>
                </div>
            </div>
        </div>

        <hr class="my-6">

        <!-- Kontak Darurat -->
        <div>
            <h2 class="text-lg font-bold mb-4">Kontak Darurat / Keluarga</h2>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <p class="text-sm text-gray-500">Nama</p>
                    <p class="font-semibold">{{ $lansia->kontak_darurat_nama ?? '-' }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Telepon</p>
                    <p class="font-semibold">{{ $lansia->kontak_darurat_telp ?? '-' }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Hubungan</p>
                    <p class="font-semibold">{{ $lansia->kontak_darurat_hubungan ?? '-' }}</p>
                </div>

                <div class="md:col-span-4">
                    <p class="text-sm text-gray-500">Alamat</p>
                    <p>{{ $lansia->kontak_darurat_alamat ?? '-' }}</p>
                </div>
            </div>
        </div>

        <hr class="my-6">

        <!-- DOKUMEN ADMINISTRASI (LENGKAP) -->
        <div>
            <h2 class="text-lg font-bold mb-4">Dokumen Administrasi</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @php
                    $dokumen = [
                        'Pas Foto' => 'foto',
                        'Surat Terminasi' => 'dokumen_surat_terminasi',
                        'KTP' => 'dokumen_ktp',
                        'Kartu Keluarga' => 'dokumen_kk',
                        'BPJS' => 'dokumen_bpjs',
                        'Surat Terlantar' => 'dokumen_surat_terlantar',
                        'Surat Sehat' => 'dokumen_surat_sehat',
                        'Surat Pengantar' => 'dokumen_surat_pengantar',
                    ];
                @endphp

                @foreach($dokumen as $label => $field)
                    <div>
                        <p class="text-sm text-gray-500">{{ $label }}</p>
                        @if(!empty($lansia->$field))
                            <a href="{{ asset('storage/' . $lansia->$field) }}"
                               target="_blank"
                               class="text-blue-600 hover:underline text-sm">
                                {{ $field === 'foto' ? 'Lihat Foto' : 'Lihat Dokumen' }}
                            </a>
                        @else
                            <p class="text-gray-400 text-sm">Tidak ada</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</div>
@endsection
