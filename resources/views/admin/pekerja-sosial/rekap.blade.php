@extends('layouts.app-admin')

@section('title', 'Rekap Data Pekerja Sosial')

@section('content')
<div class="bg-white p-6 rounded-lg shadow w-full">

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold">Rekap Data Pekerja Sosial</h2>

        <a href="{{ route('admin.pekerja-sosial.index') }}"
           class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
            Kembali
        </a>
    </div>

    <div class="mb-6 bg-gray-50 border rounded-lg p-4">
        <form method="GET" class="flex flex-wrap items-end gap-6">
            <div class="w-[280px]">
                <label class="text-sm text-gray-600">Cari Nama</label>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Nama pekerja sosial..."
                       class="w-full border rounded px-3 py-2">
            </div>

            <div class="w-[180px]">
                <label class="text-sm text-gray-600">Status Pegawai</label>
                <select name="status_pegawai" class="w-full border rounded px-3 py-2">
                    <option value="">Semua</option>
                    <option value="Tetap" {{ request('status_pegawai') == 'Tetap' ? 'selected' : '' }}>Tetap</option>
                    <option value="Honorer" {{ request('status_pegawai') == 'Honorer' ? 'selected' : '' }}>Honorer</option>
                    <option value="Kontrak" {{ request('status_pegawai') == 'Kontrak' ? 'selected' : '' }}>Kontrak</option>
                </select>
            </div>

            <div class="flex gap-3">
                <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Tampilkan
                </button>
                <a href="{{ route('admin.pekerja-sosial.rekap') }}"
                   class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 text-center">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <div class="mb-4 text-sm text-gray-700">
        <strong>Total Pekerja Sosial:</strong>
        <span class="font-semibold">{{ $totalPekerjaSosial }} Orang</span>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full border-collapse border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-3 py-2 text-center w-12">No</th>
                    <th class="border px-3 py-2">Nama</th>
                    <th class="border px-3 py-2">NIK</th>
                    <th class="border px-3 py-2">Jenis Kelamin</th>
                    <th class="border px-3 py-2">Tanggal Lahir</th>
                    <th class="border px-3 py-2">No. HP</th>
                    <th class="border px-3 py-2">Pendidikan</th>
                    <th class="border px-3 py-2">Status Pegawai</th>
                    <th class="border px-3 py-2">Mulai Bertugas</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pekerjaSosials as $index => $pekerjaSosial)
                    <tr>
                        <td class="border px-3 py-2 text-center">
                            {{ $pekerjaSosials->firstItem() + $index }}
                        </td>
                        <td class="border px-3 py-2">
                            {{ $pekerjaSosial->nama_lengkap }}
                        </td>
                        <td class="border px-3 py-2">
                            {{ $pekerjaSosial->nik ?? '-' }}
                        </td>
                        <td class="border px-3 py-2">
                            @if ($pekerjaSosial->jenis_kelamin === 'L')
                                Laki-laki
                            @elseif ($pekerjaSosial->jenis_kelamin === 'P')
                                Perempuan
                            @else
                                -
                            @endif
                        </td>
                        <td class="border px-3 py-2">
                            {{ $pekerjaSosial->tanggal_lahir?->format('d/m/Y') ?? '-' }}
                        </td>
                        <td class="border px-3 py-2">
                            {{ $pekerjaSosial->nomor_hp ?? '-' }}
                        </td>
                        <td class="border px-3 py-2">
                            {{ $pekerjaSosial->pendidikan_terakhir ?? '-' }}
                        </td>
                        <td class="border px-3 py-2">
                            {{ $pekerjaSosial->status_pegawai ?? '-' }}
                        </td>
                        <td class="border px-3 py-2">
                            {{ $pekerjaSosial->tanggal_mulai_bertugas?->format('d/m/Y') ?? '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center py-4 text-gray-500">
                            Data tidak ditemukan
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($pekerjaSosials->hasPages())
        <div class="mt-4 border-t border-gray-200 pt-3">
            {{ $pekerjaSosials->links('pagination.admin') }}
        </div>
    @endif

</div>
@endsection
