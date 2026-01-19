@extends('layouts.app-admin')

@section('title', 'Data Kegiatan')

@section('content')
<div class="space-y-6">
    
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Data Kegiatan</h1>
            <p class="text-gray-600 text-sm mt-1">Total: {{ $kegiatans->total() }} kegiatan</p>
        </div>
        <a href="{{ route('admin.kegiatan.create') }}" 
           class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Tambah Kegiatan
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded">
        <div class="flex">
            <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <p class="ml-3 text-sm text-green-700 font-medium">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    <!-- Filter & Search -->
    <div class="bg-white rounded-lg shadow p-4">
        <form method="GET" action="{{ route('admin.kegiatan.index') }}" class="space-y-3">
            <div class="flex flex-col md:flex-row gap-3">
                <!-- Search -->
                <div class="flex-1">
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Cari nama kegiatan..." 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                
                <!-- Filter Jenis -->
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

                
                <!-- Button Cari -->
                <button type="submit" class="px-6 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-800 transition-colors whitespace-nowrap">
                    Cari
                </button>
            </div>

            <!-- Quick Filter -->
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.kegiatan.index', ['filter' => 'hari_ini']) }}" 
                   class="px-4 py-2 text-sm {{ request('filter') == 'hari_ini' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} rounded-lg transition-colors">
                    Hari Ini
                </a>
                <a href="{{ route('admin.kegiatan.index', ['filter' => 'minggu_ini']) }}" 
                   class="px-4 py-2 text-sm {{ request('filter') == 'minggu_ini' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} rounded-lg transition-colors">
                    Minggu Ini
                </a>
                <a href="{{ route('admin.kegiatan.index', ['filter' => 'bulan_ini']) }}" 
                   class="px-4 py-2 text-sm {{ request('filter') == 'bulan_ini' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} rounded-lg transition-colors">
                    Bulan Ini
                </a>
                @if(request()->hasAny(['search', 'jenis', 'filter']))
                <a href="{{ route('admin.kegiatan.index') }}" 
                   class="px-4 py-2 text-sm bg-gray-300 text-gray-700 hover:bg-gray-400 rounded-lg transition-colors">
                    Reset Filter
                </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Kegiatan</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokasi</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kehadiran</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($kegiatans as $index => $kegiatan)
                    <tr class="hover:bg-gray-50">
                        <!-- No -->
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $kegiatans->firstItem() + $index }}
                        </td>

                        <!-- Nama Kegiatan -->
                        <td class="px-4 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $kegiatan->nama_kegiatan }}</div>
                            @if($kegiatan->penanggung_jawab)
                            <div class="text-xs text-gray-500">PJ: {{ $kegiatan->penanggung_jawab }}</div>
                            @endif
                        </td>

                        <!-- Jenis -->
                        <td>{{ $kegiatan->jenis_kegiatan }}</td>

                        <!-- Tanggal -->
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $kegiatan->tanggal->format('d/m/Y') }}
                            <br>
                            <span class="text-xs text-gray-400">{{ $kegiatan->tanggal->diffForHumans() }}</span>
                        </td>

                        <!-- Waktu -->
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $kegiatan->waktu_mulai }} - {{ $kegiatan->waktu_selesai }}
                        </td>

                        <!-- Lokasi -->
                        <td class="px-4 py-4 text-sm text-gray-600">
                            {{ $kegiatan->lokasi ?? '-' }}
                        </td>

                        <!-- Kehadiran -->
                        <td class="px-4 py-4 whitespace-nowrap text-sm">
                            <div class="flex items-center gap-3">
                                
                                <!-- Jumlah Hadir -->
                                <div class="flex items-center gap-1 text-gray-800">
                                    <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                                    </svg>
                                    <span class="font-semibold">
                                        {{ $kegiatan->kehadiranHadir->count() }} /
                                        {{ $kegiatan->lansias->count() }}
                                    </span>
                                </div>

                                <!--Tombol Absen-->
                                <a href="{{ route('admin.kegiatan.kehadiran', $kegiatan->id) }}"
                                class="text-blue-600 hover:text-blue-800"
                                title="Kelola Absen">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="w-5 h-5"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/>
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 3h6v4H9zM9 13l2 2 4-4"/>
                                    </svg>
                                </a>
                            </div>
                        </td>


                        <!-- Aksi -->
                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center gap-2">
                                <!-- Detail -->
                                <a href="{{ route('admin.kegiatan.show', $kegiatan) }}" 
                                   class="text-blue-600 hover:text-blue-900" title="Detail & Kehadiran">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </a>

                                <!-- Edit -->
                                <a href="{{ route('admin.kegiatan.edit', $kegiatan) }}" 
                                   class="text-yellow-600 hover:text-yellow-900" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>

                                <!-- Hapus -->
                                <form action="{{ route('admin.kegiatan.destroy', $kegiatan) }}" method="POST" 
                                      onsubmit="return confirm('Yakin ingin menghapus kegiatan {{ $kegiatan->nama_kegiatan }}?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-4 py-8 text-center text-gray-500">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <p class="mt-2">Tidak ada data kegiatan</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($kegiatans->hasPages())
        <div class="px-4 py-3 border-t border-gray-200">
            {{ $kegiatans->links() }}
        </div>
        @endif
    </div>
</div>
         <!-- TOMBOL REKAP -->
        <div class="mt-6 flex justify-end">
            <a href="{{ route('admin.kegiatan.rekap') }}"
            class="px-5 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700">
                Rekap Kegiatan
            </a>
        </div>
@endsection