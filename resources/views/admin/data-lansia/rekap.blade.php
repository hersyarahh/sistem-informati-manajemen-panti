@extends('layouts.app-admin')

@section('title', 'Rekap Data Lansia')

@section('content')
<div class="bg-white p-6 rounded-lg shadow w-full">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold">Rekap Data Lansia</h2>

        <a href="{{ route('admin.lansia.index') }}"
           class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
            Kembali
        </a>
    </div>

    {{-- FILTER --}}
    <form method="GET" class="mb-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">

            <div>
                <label class="text-sm text-gray-600">Tahun</label>
                <select name="tahun" class="w-full border rounded px-3 py-2">
                    @for ($y = now()->year; $y >= 2015; $y--)
                        <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>
                            {{ $y }}
                        </option>
                    @endfor
                </select>
            </div>

            <div>
                <label class="text-sm text-gray-600">Status</label>
                <select name="status" class="w-full border rounded px-3 py-2">
                    <option value="">Semua</option>
                    <option value="aktif" {{ $status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="keluar" {{ $status == 'keluar' ? 'selected' : '' }}>Keluar</option>
                    <option value="meninggal" {{ $status == 'meninggal' ? 'selected' : '' }}>Meninggal</option>
                </select>
            </div>

            <div class="flex gap-2">
                <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Tampilkan
                </button>

                <a href="{{ route('admin.lansia.rekap') }}"
                   class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                    Reset
                </a>
            </div>
        </div>
    </form>

    {{-- TOTAL --}}
    <div class="mb-4 text-sm text-gray-700">
        <strong>Total Lansia Tahun {{ $tahun }}:</strong>
        <span class="font-semibold">{{ $totalLansia }} Orang</span>
    </div>

    {{-- TABEL --}}
    <div class="overflow-x-auto">
        <table class="w-full border-collapse border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-3 py-2 text-center w-12">No</th>
                    <th class="border px-3 py-2">Nama</th>
                    <th class="border px-3 py-2">Tanggal Masuk</th>
                    <th class="border px-3 py-2">Status</th>
                    <th class="border px-3 py-2">Tanggal Keluar</th>
                    <th class="border px-3 py-2">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($lansias as $index => $lansia)
                    <tr>
                        {{-- NO --}}
                        <td class="border px-3 py-2 text-center">
                            {{ $index + 1 }}
                        </td>

                        {{-- NAMA --}}
                        <td class="border px-3 py-2">
                            {{ $lansia->nama_lengkap }}
                        </td>

                        {{-- TGL MASUK --}}
                        <td class="border px-3 py-2">
                            {{ $lansia->tanggal_masuk->format('d/m/Y') }}
                        </td>

                        {{-- STATUS --}}
                        <td class="border px-3 py-2 font-semibold">
                            @if ($lansia->status === 'aktif')
                                <span class="text-green-600">Aktif</span>
                            @elseif ($lansia->status === 'keluar')
                                <span class="text-orange-600">Keluar</span>
                            @elseif ($lansia->status === 'meninggal')
                                <span class="text-red-700">Meninggal</span>
                            @endif
                        </td>

                        {{-- TGL KELUAR --}}
                        <td class="border px-3 py-2">
                            {{ $lansia->terminasi?->tanggal_keluar
                                ? $lansia->terminasi->tanggal_keluar->format('d/m/Y')
                                : '-' }}
                        </td>

                        {{-- KETERANGAN --}}
                        <td class="border px-3 py-2">
                            {{ $lansia->terminasi?->keterangan ?? '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-gray-500">
                            Data tidak ditemukan
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
