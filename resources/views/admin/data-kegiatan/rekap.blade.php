@extends('layouts.app-admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-lg shadow-lg p-6 mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-white mb-2">📊 Rekap Kegiatan Lansia</h1>
                <p class="text-blue-100">Laporan dan statistik kehadiran kegiatan</p>
            </div>
            <div class="text-right">
                <div class="text-white text-sm opacity-90">Periode</div>
                <div class="text-white text-xl font-bold">{{ request('bulan') ? date('F Y', strtotime(request('bulan').'-01')) : date('F Y') }}</div>
            </div>
        </div>
    </div>

    <!-- Filter & Export Section -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <form method="GET" action="{{ route('admin.kegiatan.rekap') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Filter Bulan -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        📅 Filter Bulan
                    </label>
                    <input type="month" 
                           name="bulan" 
                           value="{{ request('bulan', date('Y-m')) }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <!-- Filter Jenis Kegiatan -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        🎯 Jenis Kegiatan
                    </label>
                    <select name="jenis"
                        class="min-w-[180px] px-4 py-2 border border-gray-300 rounded-lg
                            focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Semua Jenis</option>
                        <option value="Olahraga" {{ request('jenis') == 'Olahraga' ? 'selected' : '' }}>Olahraga</option>
                        <option value="Kesehatan" {{ request('jenis') == 'Kesehatan' ? 'selected' : '' }}>Kesehatan</option>
                        <option value="Keagamaan" {{ request('jenis') == 'Keagamaan' ? 'selected' : '' }}>Keagamaan</option>
                        <option value="Sosial" {{ request('jenis') == 'Sosial' ? 'selected' : '' }}>Sosial</option>
                        <option value="Hiburan" {{ request('jenis') == 'Hiburan' ? 'selected' : '' }}>Hiburan</option>
                    </select>

                </div>

                <!-- Tombol Filter -->
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-2 rounded-lg transition duration-200 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                        Filter
                    </button>
                </div>

                <!-- Tombol Reset -->
                <div class="flex items-end">
                    <a href="{{ route('admin.kegiatan.rekap') }}" class="w-full bg-gray-500 hover:bg-gray-600 text-white font-medium px-6 py-2 rounded-lg transition duration-200 text-center">
                        Reset
                    </a>
                </div>
            </div>
        </form>

        <!-- Export Buttons -->
        <div class="mt-6 pt-6 border-t border-gray-200">
            <div class="flex flex-wrap gap-3">
                <p class="text-sm font-medium text-gray-700 w-full mb-2">📥 Export Data:</p>
                
                <a href="{{ route('admin.kegiatan.export-excel', request()->query()) }}" 
                   class="bg-green-600 hover:bg-green-700 text-white font-medium px-6 py-2.5 rounded-lg transition duration-200 flex items-center gap-2 shadow-sm">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z"/>
                    </svg>
                    Excel (.xlsx)
                </a>

                <a href="{{ route('admin.kegiatan.export-pdf', request()->query()) }}" 
                   class="bg-red-600 hover:bg-red-700 text-white font-medium px-6 py-2.5 rounded-lg transition duration-200 flex items-center gap-2 shadow-sm">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z"/>
                    </svg>
                    PDF (.pdf)
                </a>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b-2 border-gray-200">
                            No
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b-2 border-gray-200">
                            Tanggal
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b-2 border-gray-200">
                            Nama Kegiatan
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b-2 border-gray-200">
                            Jenis
                        </th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider border-b-2 border-gray-200">
                            Hadir
                        </th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider border-b-2 border-gray-200">
                            Persentase
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($kegiatans as $index => $kegiatan)
                    <tr class="hover:bg-gray-50 transition duration-150">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $index + 1 }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-medium text-gray-900">
                                    {{ $kegiatan->tanggal->format('d M Y') }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $kegiatan->nama_kegiatan }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $kegiatan->jenis_kegiatan == 'Senam' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $kegiatan->jenis_kegiatan == 'Penyuluhan' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $kegiatan->jenis_kegiatan == 'Pemeriksaan' ? 'bg-red-100 text-red-800' : '' }}
                                {{ $kegiatan->jenis_kegiatan == 'Sosial' ? 'bg-purple-100 text-purple-800' : '' }}">
                                {{ $kegiatan->jenis_kegiatan }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span class="text-lg font-bold text-green-600">
                                {{ $kegiatan->total_hadir }}
                            </span>
                            <span class="text-xs text-gray-500">/ {{ $kegiatan->total_lansia }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            @php
                                $percentage = $kegiatan->total_lansia > 0 ? round(($kegiatan->total_hadir / $kegiatan->total_lansia) * 100, 1) : 0;
                            @endphp
                            <div class="flex items-center justify-center gap-2">
                                <div class="w-24 bg-gray-200 rounded-full h-2">
                                    <div class="h-2 rounded-full {{ $percentage >= 75 ? 'bg-green-500' : ($percentage >= 50 ? 'bg-yellow-500' : 'bg-red-500') }}" 
                                         style="width: {{ $percentage }}%"></div>
                                </div>
                                <span class="text-sm font-semibold {{ $percentage >= 75 ? 'text-green-600' : ($percentage >= 50 ? 'text-yellow-600' : 'text-red-600') }}">
                                    {{ $percentage }}%
                                </span>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <p class="text-gray-500 text-lg font-medium">Tidak ada data kegiatan</p>
                                <p class="text-gray-400 text-sm mt-1">Silakan pilih periode lain atau tambah kegiatan baru</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Back Button -->
    <div class="mt-6">
        <a href="{{ route('admin.kegiatan.index') }}" 
           class="inline-flex items-center gap-2 px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition duration-200 shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>
</div>
@endsection