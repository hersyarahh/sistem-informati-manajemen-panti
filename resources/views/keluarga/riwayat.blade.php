@extends('layouts.app-keluarga')

@section('title', 'Riwayat Kesehatan')

@section('content')
<div class="px-4 py-6 space-y-6">
    <div class="bg-white rounded-2xl shadow p-5 sm:p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <div>
                <h2 class="text-lg font-semibold text-gray-800">Riwayat Kesehatan</h2>
                <p class="text-sm text-gray-500">Catatan pemeriksaan lansia</p>
            </div>
        </div>

        <div class="mt-4 space-y-3">
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
                        <p><span class="font-medium">Dokter:</span> {{ $riwayat->nama_dokter ?? '-' }}</p>
                        <p><span class="font-medium">Petugas:</span> {{ $riwayat->nama_petugas ?? '-' }}</p>
                        <p><span class="font-medium">Catatan:</span> {{ $riwayat->catatan ?? '-' }}</p>
                    </div>
                    @if (!empty($riwayat->file_hasil))
                        <div class="mt-3">
                            <a href="{{ asset('storage/' . $riwayat->file_hasil) }}"
                               target="_blank"
                               class="text-blue-600 hover:underline text-sm">
                                Lihat File Hasil
                            </a>
                        </div>
                    @endif
                </div>
            @empty
                <div class="text-sm text-gray-500 text-center py-6">
                    Riwayat kesehatan belum tersedia.
                </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $riwayat_kesehatan->links() }}
        </div>
    </div>
</div>
@endsection
