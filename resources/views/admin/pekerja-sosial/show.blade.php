@extends('layouts.app-admin')

@section('title', 'Detail Pekerja Sosial')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-800">Detail Pekerja Sosial</h1>
        <a href="{{ route('admin.pekerja-sosial.index') }}"
           class="text-blue-600 hover:text-blue-700">Kembali</a>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center gap-4 mb-6">
            @if($pekerjaSosial->foto)
                <img class="h-16 w-16 rounded-full object-cover" src="{{ asset('storage/' . $pekerjaSosial->foto) }}" alt="">
            @else
                <div class="h-16 w-16 rounded-full bg-blue-100 flex items-center justify-center">
                    <span class="text-blue-600 font-bold text-xl">{{ substr($pekerjaSosial->nama_lengkap, 0, 1) }}</span>
                </div>
            @endif
            <div>
                <h2 class="text-lg font-semibold text-gray-800">{{ $pekerjaSosial->nama_lengkap }}</h2>
                <p class="text-sm text-gray-500">{{ $pekerjaSosial->status_pegawai ?? '-' }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-500">Telepon</p>
                <p class="text-gray-800">{{ $pekerjaSosial->nomor_hp ?? '-' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">NIP</p>
                <p class="text-gray-800">{{ $pekerjaSosial->nik ?? '-' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Alamat</p>
                <p class="text-gray-800">{{ $pekerjaSosial->alamat ?? '-' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Tanggal Lahir</p>
                <p class="text-gray-800">{{ $pekerjaSosial->tanggal_lahir?->format('d/m/Y') ?? '-' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Jenis Kelamin</p>
                <p class="text-gray-800">
                    @if($pekerjaSosial->jenis_kelamin === 'L')
                        Laki-laki
                    @elseif($pekerjaSosial->jenis_kelamin === 'P')
                        Perempuan
                    @else
                        -
                    @endif
                </p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Status Pegawai</p>
                <p class="text-gray-800">{{ $pekerjaSosial->status_pegawai ?? '-' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Pendidikan Terakhir</p>
                <p class="text-gray-800">{{ $pekerjaSosial->pendidikan_terakhir ?? '-' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Tanggal Mulai Bertugas</p>
                <p class="text-gray-800">{{ $pekerjaSosial->tanggal_mulai_bertugas?->format('d/m/Y') ?? '-' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
