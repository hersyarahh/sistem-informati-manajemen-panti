@extends('layouts.app-keluarga')

@section('title', 'Jadwal Kegiatan')

@section('content')
<div class="px-4 py-6 space-y-6">
    <div class="bg-white rounded-2xl shadow p-5 sm:p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <div>
                <h2 class="text-lg font-semibold text-gray-800">Jadwal Kegiatan Harian</h2>
                <p class="text-sm text-gray-500">Kegiatan lansia untuk hari ini</p>
            </div>
            <span class="text-xs text-gray-400">{{ now()->format('d/m/Y') }}</span>
        </div>

        <div class="mt-4 space-y-3">
            @forelse ($kegiatan_hari_ini as $kegiatan)
                @php
                    $kehadiranLansia = $kegiatan->lansias->first();
                    $statusKehadiran = $kehadiranLansia?->pivot?->status_kehadiran ?? 'belum_absen';
                @endphp
                <div class="border border-gray-100 rounded-lg p-4">
                    <div class="flex flex-wrap items-center justify-between gap-2">
                        <p class="font-semibold text-gray-800">{{ $kegiatan->nama_kegiatan }}</p>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold
                            @if($statusKehadiran === 'hadir') bg-green-100 text-green-700
                            @elseif($statusKehadiran === 'tidak_hadir') bg-red-100 text-red-700
                            @elseif($statusKehadiran === 'izin') bg-yellow-100 text-yellow-700
                            @else bg-gray-100 text-gray-700
                            @endif">
                            {{ $statusKehadiran === 'belum_absen' ? 'Belum Absen' : ucfirst(str_replace('_', ' ', $statusKehadiran)) }}
                        </span>
                    </div>
                    <p class="text-sm text-gray-600 mt-1">
                        {{ $kegiatan->waktu_mulai }} - {{ $kegiatan->waktu_selesai }} - {{ $kegiatan->lokasi }}
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
</div>
@endsection
