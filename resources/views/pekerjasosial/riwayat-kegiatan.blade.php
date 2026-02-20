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

    @if(session('error'))
        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded">
            <p class="text-sm text-red-700 font-medium">{{ session('error') }}</p>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow p-4">
        <form method="GET" action="{{ route('staff.riwayat-kegiatan') }}"
              class="grid grid-cols-1 md:grid-cols-12 gap-3 items-center">
            <div class="md:col-span-6">
                <select name="jenis"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg
                               focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Semua Golongan Kegiatan</option>
                    <option value="Olahraga" {{ request('jenis') == 'Olahraga' ? 'selected' : '' }}>Olahraga</option>
                    <option value="Kesehatan" {{ request('jenis') == 'Kesehatan' ? 'selected' : '' }}>Kesehatan</option>
                    <option value="Keagamaan" {{ request('jenis') == 'Keagamaan' ? 'selected' : '' }}>Keagamaan</option>
                    <option value="Sosial" {{ request('jenis') == 'Sosial' ? 'selected' : '' }}>Sosial</option>
                    <option value="Hiburan" {{ request('jenis') == 'Hiburan' ? 'selected' : '' }}>Hiburan</option>
                </select>
            </div>

            <div class="md:col-span-3 flex gap-2">
                <button type="submit"
                        class="w-full px-4 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-800">
                    Filter
                </button>
                @if(request()->filled('jenis'))
                <a href="{{ route('staff.riwayat-kegiatan') }}"
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
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-12">No</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kegiatan</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokasi</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($kegiatans as $kegiatan)
                        @php $isToday = $kegiatan->tanggal?->isToday(); @endphp
                        <tr class="{{ $isToday ? 'bg-emerald-50/70' : 'hover:bg-gray-50' }}">
                            <td class="px-4 py-3 text-sm text-gray-700">
                                {{ $kegiatans->firstItem() + $loop->index }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-700">
                                <div class="flex items-center gap-2">
                                    <span>{{ $kegiatan->tanggal?->format('d/m/Y') ?? '-' }}</span>
                                    @if($isToday)
                                        <span class="inline-flex items-center rounded-full bg-emerald-100 px-2 py-0.5 text-xs font-semibold text-emerald-700">
                                            Hari Ini
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-700">
                                {{ $kegiatan->nama_kegiatan ?? '-' }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-700">
                                {{ $kegiatan->jenis_kegiatan ?? '-' }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-700">
                                {{ $kegiatan->lokasi ?? '-' }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-700">
                                @if($isToday)
                                    <a href="{{ route('staff.kegiatan.kehadiran', $kegiatan) }}"
                                       class="text-blue-600 hover:text-blue-900"
                                       title="Absen Lansia">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 3h6v4H9zM9 13l2 2 4-4"/>
                                        </svg>
                                    </a>
                                @else
                                    <span class="inline-flex items-center text-gray-400" title="Absensi hanya untuk hari ini">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-gray-500">
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
