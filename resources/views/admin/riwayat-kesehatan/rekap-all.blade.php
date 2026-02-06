@extends('layouts.app-admin')

@section('title', 'Rekap Kesehatan')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Rekap Kesehatan</h1>
        <p class="text-sm text-gray-500">Riwayat pemeriksaan seluruh lansia</p>
    </div>

    <div class="bg-white rounded-lg shadow p-4">
        <form method="GET" action="{{ route('admin.riwayat-kesehatan.rekap-all') }}"
              class="grid grid-cols-1 md:grid-cols-12 gap-3 items-center">
            <div class="md:col-span-5">
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Cari nama lansia..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg
                              focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <div class="md:col-span-2 flex gap-2">
                <button type="submit"
                        class="w-full px-4 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-800">
                    Cari
                </button>

                @if(request('search'))
                <a href="{{ route('admin.riwayat-kesehatan.rekap-all') }}"
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
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($lansias as $index => $lansia)
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
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">{{ $lansia->no_kamar ?? '-' }}</td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-700">{{ ucfirst($lansia->status ?? '-') }}</td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $lansia->kondisi_kesehatan ? ucfirst(str_replace('_', ' ', $lansia->kondisi_kesehatan)) : '-' }}
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-700 max-w-xs truncate" title="{{ $lansia->riwayat_penyakit }}">{{ $lansia->riwayat_penyakit ?? '-' }}</td>
                            <td class="px-4 py-4 text-sm text-gray-700">{{ $lansia->alergi ?? '-' }}</td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('admin.riwayat-kesehatan.download', $lansia) }}"
                                   class="text-blue-600 hover:text-blue-900"
                                   title="Download PDF">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 3v12m0 0l-4-4m4 4l4-4M4 17h16"/>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-8 text-center text-gray-500">
                                Belum ada data lansia.
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

    <div class="flex items-center">
        <a href="{{ route('admin.riwayat-kesehatan.index') }}"
           class="px-6 py-2 bg-gray-200 rounded-lg">
            Kembali
        </a>
    </div>
</div>
@endsection
