@extends('layouts.app-keluarga')

@section('title', 'Profil Lansia')

@section('content')
<div class="px-4 py-6 space-y-6">
    <div class="bg-white rounded-2xl shadow p-5 sm:p-6">
        <div class="flex flex-col sm:flex-row gap-6 items-start">
            <div class="w-28 h-28 flex-shrink-0">
                @if(!empty($lansia->foto))
                    <img src="{{ asset('storage/' . $lansia->foto) }}"
                         class="w-28 h-28 rounded-full object-cover border">
                @else
                    <div class="w-28 h-28 rounded-full bg-blue-100 flex items-center justify-center">
                        <span class="text-3xl font-bold text-blue-600">
                            {{ substr($lansia->nama_lengkap, 0, 1) }}
                        </span>
                    </div>
                @endif
            </div>

            <div class="flex-1">
                <h2 class="text-lg font-semibold text-gray-800">Profil Lansia</h2>
                <p class="text-sm text-gray-500 mb-4">Biodata lengkap lansia</p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-500">Nama Lengkap</p>
                        <p class="font-semibold text-gray-800">{{ $lansia->nama_lengkap }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">NIK</p>
                        <p class="font-semibold text-gray-800">{{ $lansia->nik }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Jenis Kelamin</p>
                        <p class="font-semibold text-gray-800">
                            {{ $lansia->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-500">Tanggal Lahir</p>
                        <p class="font-semibold text-gray-800">
                            {{ $lansia->tanggal_lahir?->format('d/m/Y') ?? '-' }}
                            @if ($lansia->umur())
                                ({{ $lansia->umur() }} tahun)
                            @endif
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-500">Tanggal Masuk</p>
                        <p class="font-semibold text-gray-800">
                            {{ $lansia->tanggal_masuk?->format('d/m/Y') ?? '-' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-500">No. Kamar</p>
                        <p class="font-semibold text-gray-800">{{ $lansia->no_kamar ?? '-' }}</p>
                    </div>
                    <div class="sm:col-span-2">
                        <p class="text-gray-500">Alamat Asal</p>
                        <p class="font-semibold text-gray-800">{{ $lansia->alamat_asal ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Status</p>
                        <p class="font-semibold text-gray-800">{{ $lansia->status ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow p-5 sm:p-6">
        <h3 class="text-base font-semibold text-gray-800 mb-4">Kontak Darurat</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
            <div>
                <p class="text-gray-500">Nama</p>
                <p class="font-semibold text-gray-800">{{ $lansia->kontak_darurat_nama ?? '-' }}</p>
            </div>
            <div>
                <p class="text-gray-500">Telepon</p>
                <p class="font-semibold text-gray-800">{{ $lansia->kontak_darurat_telp ?? '-' }}</p>
            </div>
            <div>
                <p class="text-gray-500">Hubungan</p>
                <p class="font-semibold text-gray-800">{{ $lansia->kontak_darurat_hubungan ?? '-' }}</p>
            </div>
            <div class="sm:col-span-2">
                <p class="text-gray-500">Alamat</p>
                <p class="font-semibold text-gray-800">{{ $lansia->kontak_darurat_alamat ?? '-' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
