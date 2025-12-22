@extends('layouts.app-admin')

@section('title', 'Absen Kegiatan')

@section('content')
<div class="bg-white p-6 rounded-lg shadow w-full">

    <h2 class="text-xl font-bold mb-6">
        Absen Kegiatan: {{ $kegiatan->nama_kegiatan }}
    </h2>

    <form action="{{ route('admin.kegiatan.kehadiran.store', $kegiatan->id) }}" method="POST">
        @csrf

        <div class="overflow-x-auto">
            <table class="w-full border border-gray-300 rounded">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border p-3 text-left">Nama Lengkap</th>
                        <th class="border p-3 text-center">Hadir</th>
                        <th class="border p-3 text-center">Tidak Hadir</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($lansias as $lansia)
                    <tr class="hover:bg-gray-50">
                        <td class="border p-3">
                            {{ $lansia->nama_lengkap }}
                        </td>

                        <td class="border p-3 text-center">
                            <input type="radio"
                                   name="kehadiran[{{ $lansia->id }}]"
                                   value="hadir"
                                   {{ (isset($kehadiran[$lansia->id]) && $kehadiran[$lansia->id] === 'hadir') ? 'checked' : '' }}>
                        </td>

                        <td class="border p-3 text-center">
                            <input type="radio"
                                   name="kehadiran[{{ $lansia->id }}]"
                                   value="tidak_hadir"
                                   {{ (isset($kehadiran[$lansia->id]) && $kehadiran[$lansia->id] === 'tidak_hadir') ? 'checked' : '' }}>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center p-4 text-gray-500">
                            Tidak ada data lansia aktif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6 flex gap-3">
            <button type="submit"
                class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">
                Simpan Kehadiran
            </button>

            <a href="{{ route('admin.kegiatan.index') }}"
               class="px-5 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg">
                Kembali
            </a>
        </div>
    </form>
</div>
@endsection
