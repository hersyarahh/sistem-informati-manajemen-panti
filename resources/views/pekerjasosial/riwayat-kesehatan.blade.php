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

    <div class="bg-white rounded-lg shadow">
        <div class="divide-y divide-gray-200">
            @forelse ($lansias as $lansia)
                <a href="{{ route('staff.lansia.edit', $lansia) }}"
                   class="flex items-center justify-between px-5 py-4 hover:bg-gray-50 transition">
                    <div class="flex items-center gap-4">
                        <div class="h-10 w-10">
                            @if($lansia->foto)
                                <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $lansia->foto) }}" alt="">
                            @else
                                <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                    <span class="text-blue-600 font-bold text-lg">{{ substr($lansia->nama_lengkap, 0, 1) }}</span>
                                </div>
                            @endif
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900">{{ $lansia->nama_lengkap }}</p>
                            <p class="text-xs text-gray-500">No. Kamar: {{ $lansia->no_kamar ?? '-' }}</p>
                        </div>
                    </div>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            @empty
                <div class="px-5 py-8 text-center text-gray-500">
                    Tidak ada data lansia
                </div>
            @endforelse
        </div>

        @if($lansias->hasPages())
        <div class="px-4 py-3 border-t border-gray-200">
            {{ $lansias->links('pagination.admin') }}
        </div>
        @endif
    </div>
</div>
@endsection
