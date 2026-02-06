@extends('layouts.app-admin')

@section('title', 'Rekap Kesehatan')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Rekap Kesehatan</h1>
        <p class="text-sm text-gray-500">{{ $lansia->nama_lengkap }}</p>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Pemeriksaan</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keluhan</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Diagnosa</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tindakan</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Petugas</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($riwayats as $riwayat)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm text-gray-700">
                                {{ $riwayat->tanggal_periksa?->format('d/m/Y') ?? '-' }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $riwayat->jenis_pemeriksaan ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $riwayat->keluhan ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $riwayat->diagnosa ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $riwayat->tindakan ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $riwayat->nama_petugas ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                                Belum ada riwayat kesehatan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($riwayats->hasPages())
        <div class="px-4 py-3 border-t border-gray-200">
            {{ $riwayats->links('pagination.admin') }}
        </div>
        @endif
    </div>

    <div class="flex items-center">
        <a href="{{ route('admin.riwayat-kesehatan.show', $lansia) }}"
           class="px-6 py-2 bg-gray-200 rounded-lg">
            Kembali
        </a>
    </div>
</div>
@endsection
