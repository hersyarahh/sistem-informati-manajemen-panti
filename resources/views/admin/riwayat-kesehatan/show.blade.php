@extends('layouts.app-admin')

@section('title', 'Detail Riwayat Kesehatan')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-800">Detail Riwayat Kesehatan</h1>
    </div>

    @php $riwayat = $lansia->latestRiwayatKesehatan; @endphp

    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold mb-4">Ringkasan Kesehatan</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div>
                <p class="text-gray-500">Nama Lansia</p>
                <p class="font-semibold text-gray-800">{{ $lansia->nama_lengkap }}</p>
            </div>
            <div>
                <p class="text-gray-500">No. Kamar</p>
                <p class="font-semibold text-gray-800">{{ $lansia->no_kamar ?? '-' }}</p>
            </div>
            <div>
                <p class="text-gray-500">Kondisi</p>
                <p class="font-semibold text-gray-800">
                    {{ $lansia->kondisi_kesehatan ? ucfirst(str_replace('_', ' ', $lansia->kondisi_kesehatan)) : '-' }}
                </p>
            </div>
            <div>
                <p class="text-gray-500">Riwayat Penyakit</p>
                <p class="font-semibold text-gray-800">{{ $lansia->riwayat_penyakit ?? '-' }}</p>
            </div>
            <div>
                <p class="text-gray-500">Alergi</p>
                <p class="font-semibold text-gray-800">{{ $lansia->alergi ?? '-' }}</p>
            </div>
            <div>
                <p class="text-gray-500">Status</p>
                <p class="font-semibold text-gray-800">{{ ucfirst($lansia->status ?? '-') }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold mb-4">Pemeriksaan Terakhir</h2>

        @if ($riwayat)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-gray-500">Tanggal Periksa</p>
                    <p class="font-semibold text-gray-800">{{ $riwayat->tanggal_periksa?->format('d/m/Y') ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Jenis Pemeriksaan</p>
                    <p class="font-semibold text-gray-800">{{ $riwayat->jenis_pemeriksaan ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Keluhan</p>
                    <p class="font-semibold text-gray-800">{{ $riwayat->keluhan ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Diagnosa</p>
                    <p class="font-semibold text-gray-800">{{ $riwayat->diagnosa ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Tindakan</p>
                    <p class="font-semibold text-gray-800">{{ $riwayat->tindakan ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Resep Obat</p>
                    <p class="font-semibold text-gray-800">{{ $riwayat->resep_obat ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Penanggung Jawab</p>
                    <p class="font-semibold text-gray-800">{{ $riwayat->nama_petugas ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Catatan</p>
                    <p class="font-semibold text-gray-800">{{ $riwayat->catatan ?? '-' }}</p>
                </div>
                <div class="md:col-span-2">
                    <p class="text-gray-500">File Hasil</p>
                    @if ($riwayat->file_hasil)
                        <a href="{{ asset('storage/' . $riwayat->file_hasil) }}"
                           class="text-blue-600 hover:text-blue-700 font-semibold"
                           target="_blank">
                            Lihat file hasil
                        </a>
                    @else
                        <p class="font-semibold text-gray-800">-</p>
                    @endif
                </div>
            </div>
        @else
            <p class="text-sm text-gray-500">Belum ada data pemeriksaan.</p>
        @endif
    </div>

    <div class="flex items-center">
        <a href="{{ route('admin.riwayat-kesehatan.index') }}"
           class="px-6 py-2 bg-gray-200 rounded-lg">
            Kembali
        </a>
    </div>
</div>
@endsection
