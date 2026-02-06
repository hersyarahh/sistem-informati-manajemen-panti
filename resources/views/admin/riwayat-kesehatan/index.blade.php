@extends('layouts.app-admin')

@section('title', 'Riwayat Kesehatan')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Riwayat Kesehatan</h1>
            <p class="text-gray-600 text-sm mt-1">Total: {{ $lansias->total() }} lansia</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.riwayat-kesehatan.rekap-all') }}"
               class="inline-flex items-center justify-center px-5 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition-colors">
                Rekap Kesehatan
            </a>
            <a href="{{ route('admin.riwayat-kesehatan.assign') }}"
               class="inline-flex items-center justify-center px-5 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition-colors">
                Tentukan Staff
            </a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-4">
        <form method="GET" action="{{ route('admin.riwayat-kesehatan.index') }}"
              class="grid grid-cols-1 md:grid-cols-12 gap-3 items-center">
            <div class="md:col-span-5">
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Cari nama lansia..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg
                              focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <div class="md:col-span-2">
                <select name="no_kamar"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg
                               focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Semua Kamar</option>
                    @foreach ($rooms as $room)
                        <option value="{{ $room }}" {{ request('no_kamar') == $room ? 'selected' : '' }}>
                            {{ $room }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="md:col-span-2 flex gap-2">
                <button type="submit"
                        class="w-full px-4 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-800">
                    Cari
                </button>

                @if(request('search') || request('no_kamar'))
                <a href="{{ route('admin.riwayat-kesehatan.index') }}"
                   class="w-full px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 text-center">
                    Reset
                </a>
                @endif
            </div>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Kamar</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kondisi</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Riwayat Penyakit</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alergi</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pemeriksaan Terakhir</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penanggung Jawab</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($lansias as $index => $lansia)
                        @php $riwayat = $lansia->latestRiwayatKesehatan; @endphp
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $lansias->firstItem() + $index }}
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        @if($lansia->foto)
                                            <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $lansia->foto) }}" alt="">
                                        @else
                                            <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                                <span class="text-blue-600 font-bold text-lg">{{ substr($lansia->nama_lengkap, 0, 1) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">{{ $lansia->nama_lengkap }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                {{ $lansia->no_kamar ?? '-' }}
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full
                                    @if($lansia->status === 'aktif') bg-green-100 text-green-800
                                    @elseif($lansia->status === 'keluar') bg-gray-100 text-gray-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    {{ ucfirst($lansia->status ?? '-') }}
                                </span>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ $lansia->kondisi_kesehatan ? ucfirst(str_replace('_', ' ', $lansia->kondisi_kesehatan)) : '-' }}
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-600 max-w-xs truncate" title="{{ $lansia->riwayat_penyakit }}">
                                {{ $lansia->riwayat_penyakit ?? '-' }}
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-600">
                                {{ $lansia->alergi ?? '-' }}
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-600">
                                @if ($riwayat)
                                    <div class="font-medium text-gray-800">{{ $riwayat->jenis_pemeriksaan ?? '-' }}</div>
                                    <div class="text-xs text-gray-500">{{ $riwayat->tanggal_periksa?->format('d/m/Y') ?? '-' }}</div>
                                    <div class="text-xs text-gray-500">Diagnosa: {{ $riwayat->diagnosa ?? '-' }}</div>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-600">
                                @php
                                    $staffNames = $lansia->karyawans->pluck('name')->filter()->values();
                                @endphp
                                @if ($staffNames->isNotEmpty())
                                    {{ $staffNames->join(', ') }}
                                @else
                                    {{ $riwayat?->nama_petugas ?? '-' }}
                                @endif
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('admin.riwayat-kesehatan.show', $lansia) }}"
                                   class="text-blue-600 hover:text-blue-900"
                                   title="Lihat Detail">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </a>
                            </td>
                            
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="px-4 py-8 text-center text-gray-500">
                                Tidak ada data lansia
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($lansias->hasPages())
        <div class="px-4 py-3 border-t border-gray-200">
            {{ $lansias->links('pagination.admin') }}
        </div>
        @endif
    </div>
</div>
@endsection
