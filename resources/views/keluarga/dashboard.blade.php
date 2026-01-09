@extends('layouts.app-keluarga')

@section('title', 'Beranda')

@section('content')
<div class="px-4 py-6 space-y-6">
    @php
        $flashMessage = session('message');
    @endphp

    @if (!empty($flashMessage) || !empty($message))
        <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 px-4 py-3 rounded-lg">
            {{ $flashMessage ?? $message }}
        </div>
    @endif

    @if ($lansia)
        <div class="bg-white rounded-2xl shadow p-5 sm:p-6">
            <div class="flex flex-col sm:flex-row gap-5">
                <div class="w-24 h-24 sm:w-28 sm:h-28 flex-shrink-0">
                    @if(!empty($lansia->foto))
                        <img src="{{ asset('storage/' . $lansia->foto) }}"
                             class="w-full h-full rounded-full object-cover border">
                    @else
                        <div class="w-full h-full rounded-full bg-blue-100 flex items-center justify-center">
                            <span class="text-3xl font-bold text-blue-600">
                                {{ substr($lansia->nama_lengkap, 0, 1) }}
                            </span>
                        </div>
                    @endif
                </div>

                <div class="flex-1">
                    <h2 class="text-lg font-semibold text-gray-800">Profil Lansia</h2>
                    <p class="text-sm text-gray-500 mb-4">Biodata singkat dan kondisi terbaru</p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-gray-500">Nama Lengkap</p>
                            <p class="font-semibold text-gray-800">{{ $lansia->nama_lengkap }}</p>
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
                            <p class="text-gray-500">No. Kamar</p>
                            <p class="font-semibold text-gray-800">{{ $lansia->no_kamar ?? '-' }}</p>
                        </div>
                        <div class="sm:col-span-2">
                            <p class="text-gray-500">Alamat Asal</p>
                            <p class="font-semibold text-gray-800">{{ $lansia->alamat_asal ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Kondisi Kesehatan</p>
                            <span class="inline-flex items-center mt-1 px-3 py-1 rounded-full text-xs font-semibold
                                @if($lansia->kondisi_kesehatan === 'sehat') bg-green-100 text-green-800
                                @elseif($lansia->kondisi_kesehatan === 'sakit_ringan') bg-yellow-100 text-yellow-800
                                @elseif($lansia->kondisi_kesehatan === 'sakit_berat') bg-orange-100 text-orange-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ ucfirst(str_replace('_', ' ', $lansia->kondisi_kesehatan)) }}
                            </span>
                        </div>
                        <div>
                            <p class="text-gray-500">Riwayat Penyakit</p>
                            <p class="font-semibold text-gray-800">{{ $lansia->riwayat_penyakit ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-2xl shadow p-5 sm:p-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-base font-semibold text-gray-800">Jadwal Kegiatan Harian</h3>
                        <p class="text-sm text-gray-500">Kegiatan yang berlangsung hari ini</p>
                    </div>
                    <span class="text-xs text-gray-400">{{ now()->format('d/m/Y') }}</span>
                </div>

                <div class="space-y-3">
                    @forelse ($kegiatan_hari_ini as $kegiatan)
                        <div class="border border-gray-100 rounded-lg p-4">
                            <p class="font-semibold text-gray-800">{{ $kegiatan->nama_kegiatan }}</p>
                            <p class="text-sm text-gray-600">
                                {{ $kegiatan->waktu_mulai }} - {{ $kegiatan->waktu_selesai }}
                                - {{ $kegiatan->lokasi }}
                            </p>
                            @if (!empty($kegiatan->deskripsi))
                                <p class="text-sm text-gray-500 mt-2">{{ $kegiatan->deskripsi }}</p>
                            @endif
                        </div>
                    @empty
                        <div class="text-sm text-gray-500 text-center py-6">
                            Belum ada kegiatan untuk hari ini.
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow p-5 sm:p-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-base font-semibold text-gray-800">Riwayat Kesehatan</h3>
                        <p class="text-sm text-gray-500">Pemeriksaan terakhir lansia</p>
                    </div>
                </div>

                <div class="space-y-3">
                    @forelse ($riwayat_kesehatan as $riwayat)
                        <div class="border border-gray-100 rounded-lg p-4">
                            <div class="flex flex-wrap items-center justify-between gap-2">
                                <p class="font-semibold text-gray-800">{{ $riwayat->jenis_pemeriksaan }}</p>
                                <span class="text-xs text-gray-400">{{ $riwayat->tanggal_periksa?->format('d/m/Y') }}</span>
                            </div>
                            <div class="text-sm text-gray-600 space-y-1 mt-2">
                                <p><span class="font-medium">Keluhan:</span> {{ $riwayat->keluhan ?? '-' }}</p>
                                <p><span class="font-medium">Diagnosa:</span> {{ $riwayat->diagnosa ?? '-' }}</p>
                                <p><span class="font-medium">Tindakan:</span> {{ $riwayat->tindakan ?? '-' }}</p>
                                <p><span class="font-medium">Resep:</span> {{ $riwayat->resep_obat ?? '-' }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-sm text-gray-500 text-center py-6">
                            Riwayat kesehatan belum tersedia.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
