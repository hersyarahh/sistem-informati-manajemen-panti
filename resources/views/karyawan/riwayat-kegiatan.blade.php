@extends('layouts.app-karyawan')

@section('title', 'Riwayat Kegiatan')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Riwayat Kegiatan</h1>
            <p class="text-gray-600 text-sm mt-1">Absensi kegiatan lansia yang ditugaskan</p>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded">
            <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-12">No</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kegiatan</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokasi</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($kegiatans as $kegiatan)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm text-gray-700">
                                {{ $kegiatans->firstItem() + $loop->index }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-700">
                                {{ $kegiatan->tanggal?->format('d/m/Y') ?? '-' }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-700">
                                {{ $kegiatan->nama_kegiatan ?? '-' }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-700">
                                {{ $kegiatan->lokasi ?? '-' }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-700">
                                <a href="{{ route('karyawan.kegiatan.kehadiran', $kegiatan) }}"
                                   class="text-blue-600 hover:text-blue-900"
                                   title="Absen Lansia">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 3h6v4H9zM9 13l2 2 4-4"/>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-gray-500">
                                Belum ada data kegiatan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($kegiatans->hasPages())
        <div class="px-4 py-3 border-t border-gray-200">
            {{ $kegiatans->links('pagination.admin') }}
        </div>
        @endif
    </div>
</div>
@endsection
