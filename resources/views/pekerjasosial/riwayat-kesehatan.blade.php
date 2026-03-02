@extends('layouts.app-karyawan')

@section('title', 'Riwayat Kesehatan')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Riwayat Kesehatan</h1>
            <p class="text-gray-600 text-sm mt-1">Total: {{ $lansias->total() }} lansia</p>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-4">
        <form method="GET" action="{{ route('staff.riwayat-kesehatan') }}"
              class="grid grid-cols-1 md:grid-cols-12 gap-3 items-center">

            <div class="md:col-span-6">
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
                <a href="{{ route('staff.riwayat-kesehatan') }}"
                   class="w-full px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 text-center">
                    Reset
                </a>
                @endif
            </div>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-gray-700">
                <thead class="bg-gray-50 text-xs font-semibold uppercase tracking-wide text-gray-500">
                    <tr>
                        <th class="px-5 py-4 text-left">No</th>
                        <th class="px-5 py-4 text-left">Lansia</th>
                        <th class="px-5 py-4 text-left">No. Kamar</th>
                        <th class="px-5 py-4 text-left">Kondisi</th>
                        <th class="px-5 py-4 text-left">Riwayat Terakhir</th>
                        <th class="px-5 py-4 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($lansias as $index => $lansia)
                        @php
                            $riwayat = $lansia->latestRiwayatKesehatan;
                            $kondisi = $lansia->kondisi_kesehatan ?? 'belum_diisi';
                            $kondisiStyles = match ($kondisi) {
                                'sehat' => 'bg-green-100 text-green-700',
                                'sakit_ringan' => 'bg-yellow-100 text-yellow-700',
                                'sakit_berat' => 'bg-red-100 text-red-700',
                                'perawatan_khusus' => 'bg-purple-100 text-purple-700',
                                default => 'bg-gray-100 text-gray-600',
                            };
                        @endphp
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-5 py-4 align-top">
                                {{ $lansias->firstItem() + $index }}
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 shrink-0">
                                        @if($lansia->foto)
                                            <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $lansia->foto) }}" alt="">
                                        @else
                                            <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                                <span class="text-blue-600 font-bold text-lg">{{ substr($lansia->nama_lengkap, 0, 1) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $lansia->nama_lengkap }}</p>
                                        <p class="text-xs text-gray-500">{{ $lansia->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4 align-top font-medium text-gray-900">{{ $lansia->no_kamar ?? '-' }}</td>
                            <td class="px-5 py-4 align-top">
                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $kondisiStyles }}">
                                    {{ ucwords(str_replace('_', ' ', $lansia->kondisi_kesehatan ?? 'belum diisi')) }}
                                </span>
                            </td>
                            <td class="px-5 py-4">
                                @if($riwayat)
                                    <div class="space-y-1">
                                        <p class="font-semibold text-gray-900">
                                            {{ $riwayat->jenis_pemeriksaan ?: 'Pemeriksaan kesehatan' }}
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            {{ optional($riwayat->tanggal_periksa)->format('d/m/Y') ?: '-' }}
                                        </p>
                                        <p class="text-xs text-gray-600">
                                            {{ \Illuminate\Support\Str::limit($riwayat->diagnosa ?: ($riwayat->keluhan ?: 'Belum ada ringkasan pemeriksaan.'), 60) }}
                                        </p>
                                    </div>
                                @else
                                    <span class="text-xs text-gray-500">Belum ada riwayat kesehatan.</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 align-top">
                                <a href="{{ route('staff.lansia.edit', $lansia) }}"
                                   class="text-blue-600 hover:text-blue-900"
                                   title="Lihat detail dan update riwayat kesehatan">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-8 text-center text-gray-500">
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
