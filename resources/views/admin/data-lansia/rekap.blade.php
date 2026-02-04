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

    @php
        $months = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        ];
        $periode = request('periode', $bulan ? 'bulan' : 'tahun');
    @endphp

    {{-- FILTER & PERIODE --}}
    <div class="mb-6 bg-gray-50 border rounded-lg p-4">
        <form method="GET" class="flex flex-wrap items-end gap-6">
            <div class="w-[300px]">
                <label class="text-sm text-gray-600">Periode Rekap</label>
                <div class="mt-1 flex items-center gap-6 rounded border bg-white px-3 py-2">
                    <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                        <input type="radio" name="periode" value="bulan" {{ $periode === 'bulan' ? 'checked' : '' }}>
                        Bulanan
                    </label>
                    <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                        <input type="radio" name="periode" value="tahun" {{ $periode === 'tahun' ? 'checked' : '' }}>
                        Tahunan
                    </label>
                </div>
            </div>

            <div class="w-[140px]">
                <label class="text-sm text-gray-600">Tahun</label>
                <select name="tahun" class="w-full border rounded px-3 py-2">
                    @for ($y = now()->year; $y >= 2015; $y--)
                        <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>
                            {{ $y }}
                        </option>
                    @endfor
                </select>
            </div>

            <div class="w-[180px]">
                <label class="text-sm text-gray-600">Bulan</label>
                <select name="bulan" class="w-full border rounded px-3 py-2" {{ $periode === 'tahun' ? 'disabled' : '' }}>
                    <option value="">Semua Bulan</option>
                    @foreach ($months as $num => $name)
                        <option value="{{ $num }}" {{ (string)$bulan === (string)$num ? 'selected' : '' }}>
                            {{ $name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="w-[140px]">
                <label class="text-sm text-gray-600">Status</label>
                <select name="status" class="w-full border rounded px-3 py-2">
                    <option value="">Semua</option>
                    <option value="aktif" {{ $status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="keluar" {{ $status == 'keluar' ? 'selected' : '' }}>Keluar</option>
                    <option value="meninggal" {{ $status == 'meninggal' ? 'selected' : '' }}>Meninggal</option>
                </select>
            </div>

            <div class="flex gap-3">
                <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Tampilkan
                </button>
                <a href="{{ route('admin.lansia.rekap') }}"
                   class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 text-center">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
        <div class="text-xs text-gray-500">
            Export mengikuti filter periode yang dipilih (bulanan atau tahunan).
        </div>
        <a href="{{ route('admin.lansia.rekap-excel', request()->query()) }}"
           class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 text-center md:w-auto">
            Export Excel
        </a>
    </div>

    <script>
        (function () {
            const bulanSelect = document.querySelector('select[name="bulan"]');
            const periodeInputs = document.querySelectorAll('input[name="periode"]');

            if (!bulanSelect || !periodeInputs.length) {
                return;
            }

            const updateBulanState = () => {
                const selected = document.querySelector('input[name="periode"]:checked');
                const isBulanan = selected?.value === 'bulan';
                bulanSelect.disabled = !isBulanan;
            };

            periodeInputs.forEach((input) => {
                input.addEventListener('change', updateBulanState);
            });

            updateBulanState();
        })();
    </script>

    {{-- TOTAL --}}
    <div class="mb-4 text-sm text-gray-700">
        <strong>Total Lansia:</strong>
        <span class="font-semibold">{{ $totalLansia }} Orang</span>
        <span class="text-gray-500">
            ({{ $tahun }}{{ $bulan ? ' - ' . $months[$bulan] : '' }})
        </span>
    </div>

    {{-- TABEL --}}
    <div class="overflow-x-auto">
        <table class="w-full border-collapse border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-3 py-2 text-center w-12">No</th>
                    <th class="border px-3 py-2">Nama</th>
                    <th class="border px-3 py-2">Tanggal Lahir</th>
                    <th class="border px-3 py-2">Asal</th>
                    <th class="border px-3 py-2">Tanggal Masuk</th>
                    <th class="border px-3 py-2">Status</th>
                    <th class="border px-3 py-2">Tanggal Keluar</th>
                    <th class="border px-3 py-2">Keterangan</th>
                    <th class="border px-3 py-2">Surat Terminasi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($lansias as $index => $lansia)
                    <tr>
                        {{-- NO --}}
                        <td class="border px-3 py-2 text-center">
                            {{ $lansias->firstItem() + $index }}
                        </td>

                        {{-- NAMA --}}
                        <td class="border px-3 py-2">
                            {{ $lansia->nama_lengkap }}
                        </td>

                        {{-- TGL LAHIR --}}
                        <td class="border px-3 py-2">
                            {{ $lansia->tanggal_lahir?->format('d/m/Y') ?? '-' }}
                        </td>

                        {{-- ASAL --}}
                        <td class="border px-3 py-2">
                            {{ $lansia->daerah_asal ?? $lansia->alamat_asal ?? '-' }}
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

                        {{-- SURAT TERMINASI --}}
                        <td class="border px-3 py-2">
                            @if ($lansia->dokumen_surat_terminasi)
                                <a href="{{ asset('storage/' . $lansia->dokumen_surat_terminasi) }}"
                                   target="_blank"
                                   class="text-blue-600 hover:underline">
                                    Lihat
                                </a>
                            @else
                                -
                            @endif
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

    {{-- PAGINATION --}}
    @if($lansias->hasPages())
        <div class="mt-4 border-t border-gray-200 pt-3">
            {{ $lansias->links('pagination.admin') }}
        </div>
    @endif

</div>
@endsection
