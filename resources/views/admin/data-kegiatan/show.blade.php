@extends('layouts.app-admin')

@section('title', 'Detail Kegiatan')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                Detail Kegiatan
            </h1>
            <p class="text-sm text-gray-600 mt-1">
                Informasi lengkap & kehadiran lansia
            </p>
        </div>

        <div class="flex gap-2">
            <a href="{{ route('admin.kegiatan.index') }}"
                class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                ← Kembali
            </a>

            <a href="{{ route('admin.kegiatan.edit', $kegiatan) }}"
                class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">
                Edit
            </a>

            <a href="{{ route('admin.kegiatan.kehadiran', $kegiatan->id) }}"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Kelola Kehadiran
            </a>
        </div>
    </div>

    <!-- Informasi Kegiatan -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div>
                <h2 class="text-xl font-semibold text-gray-800 mb-2">
                    {{ $kegiatan->nama_kegiatan }}
                </h2>

                <span class="inline-block px-3 py-1 text-sm rounded-full bg-blue-100 text-blue-700">
                    {{ $kegiatan->jenis_kegiatan }}
                </span>

                <p class="mt-4 text-sm text-gray-600">
                    📅 {{ $kegiatan->tanggal->format('d/m/Y') }}
                    <span class="text-gray-400">
                        ({{ $kegiatan->tanggal->diffForHumans() }})
                    </span>
                </p>

                <p class="text-sm text-gray-600 mt-1">
                    ⏰ {{ $kegiatan->waktu_mulai }} - {{ $kegiatan->waktu_selesai }}
                </p>

                <p class="text-sm text-gray-600 mt-1">
                    📍 {{ $kegiatan->lokasi }}
                </p>
            </div>

            <div>
                <h3 class="font-medium text-gray-700 mb-2">Deskripsi</h3>
                <p class="text-sm text-gray-600 leading-relaxed">
                    {{ $kegiatan->deskripsi ?? 'Tidak ada deskripsi kegiatan.' }}
                </p>
            </div>

        </div>
    </div>

    <!-- Statistik Kehadiran -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        <div class="bg-white rounded-lg shadow p-4">
            <p class="text-sm text-gray-500">Total Lansia</p>
            <p class="text-2xl font-bold text-gray-800">
                {{ $totalLansia }}
            </p>
        </div>

        <div class="bg-white rounded-lg shadow p-4">
            <p class="text-sm text-gray-500">Hadir</p>
            <p class="text-2xl font-bold text-green-600">
                {{ $totalHadir }}
            </p>
        </div>

        <div class="bg-white rounded-lg shadow p-4">
            <p class="text-sm text-gray-500">Tidak Hadir</p>
            <p class="text-2xl font-bold text-red-500">
                {{ $totalTidakHadir }}
            </p>
        </div>

    </div>

    <!-- Tabel Kehadiran Lansia -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                            No
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                            Nama Lansia
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                            Status Kehadiran
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @forelse($kegiatan->lansias as $index => $lansia)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm">
                            {{ $index + 1 }}
                        </td>

                        <td class="px-4 py-3 text-sm text-gray-800">
                            {{ $lansia->nama_lengkap }}
                        </td>

                        <td class="px-4 py-3">
                            @if($lansia->pivot->status_kehadiran === 'hadir')
                            <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-700">
                                Hadir
                            </span>
                            @else
                            <span class="px-3 py-1 text-xs rounded-full bg-red-100 text-red-700">
                                Tidak Hadir
                            </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-4 py-6 text-center text-gray-500">
                            Belum ada data kehadiran.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
