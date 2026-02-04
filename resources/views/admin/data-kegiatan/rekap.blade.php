@extends('layouts.app-admin')

@section('content')
<div class="bg-white p-6 rounded-lg shadow w-full">

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold">Rekap Data Kegiatan</h2>

        <a href="{{ route('admin.kegiatan.index') }}"
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

        $periode = $periode ?? request('periode', 'bulan');
        $tahun = $tahun ?? request('tahun', now()->year);
        $bulan = $bulan ?? request('bulan');

        if ($periode === 'bulan' && !$bulan) {
            $bulan = now()->format('m');
        }
    @endphp

    <div class="mb-6 bg-gray-50 border rounded-lg p-4">
        <form method="GET" action="{{ route('admin.kegiatan.rekap') }}" class="flex flex-wrap items-end gap-6">
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
                        <option value="{{ $y }}" {{ (string)$tahun === (string)$y ? 'selected' : '' }}>
                            {{ $y }}
                        </option>
                    @endfor
                </select>
            </div>

            <div class="w-[180px]">
                <label class="text-sm text-gray-600">Bulan</label>
                <select name="bulan" class="w-full border rounded px-3 py-2" {{ $periode === 'tahun' ? 'disabled' : '' }}>
                    <option value="">Semua Bulan</option>
                    @foreach($months as $num => $name)
                        <option value="{{ $num }}" {{ (string)$bulan === (string)$num ? 'selected' : '' }}>
                            {{ $name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="w-[200px]">
                <label class="text-sm text-gray-600">Jenis Kegiatan</label>
                <select name="jenis" class="w-full border rounded px-3 py-2">
                    <option value="">Semua Jenis</option>
                    <option value="Olahraga" {{ request('jenis') == 'Olahraga' ? 'selected' : '' }}>Olahraga</option>
                    <option value="Kesehatan" {{ request('jenis') == 'Kesehatan' ? 'selected' : '' }}>Kesehatan</option>
                    <option value="Keagamaan" {{ request('jenis') == 'Keagamaan' ? 'selected' : '' }}>Keagamaan</option>
                    <option value="Sosial" {{ request('jenis') == 'Sosial' ? 'selected' : '' }}>Sosial</option>
                    <option value="Hiburan" {{ request('jenis') == 'Hiburan' ? 'selected' : '' }}>Hiburan</option>
                </select>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Tampilkan
                </button>
                <a href="{{ route('admin.kegiatan.rekap') }}"
                   class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 text-center">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
        <div class="text-xs text-gray-500">
            Export mengikuti filter periode yang dipilih.
        </div>
        <a href="{{ route('admin.kegiatan.export-pdf', request()->query()) }}"
           class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 text-center md:w-auto">
            PDF (.pdf)
        </a>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b-2 border-gray-200">
                            No
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b-2 border-gray-200">
                            Tanggal
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b-2 border-gray-200">
                            Nama Kegiatan
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b-2 border-gray-200">
                            Jenis
                        </th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider border-b-2 border-gray-200">
                            Hadir
                        </th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider border-b-2 border-gray-200">
                            Persentase
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($kegiatans as $index => $kegiatan)
                    <tr class="hover:bg-gray-50 transition duration-150">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $index + 1 }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-medium text-gray-900">
                                    {{ $kegiatan->tanggal->format('d M Y') }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $kegiatan->nama_kegiatan }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $kegiatan->jenis_kegiatan == 'Senam' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $kegiatan->jenis_kegiatan == 'Penyuluhan' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $kegiatan->jenis_kegiatan == 'Pemeriksaan' ? 'bg-red-100 text-red-800' : '' }}
                                {{ $kegiatan->jenis_kegiatan == 'Sosial' ? 'bg-purple-100 text-purple-800' : '' }}">
                                {{ $kegiatan->jenis_kegiatan }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span class="text-lg font-bold text-green-600">
                                {{ $kegiatan->total_hadir }}
                            </span>
                            <span class="text-xs text-gray-500">/ {{ $kegiatan->total_lansia }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            @php
                            $percentage = $kegiatan->total_lansia > 0 ? round(($kegiatan->total_hadir / $kegiatan->total_lansia) * 100, 1) : 0;
                            @endphp
                            <div class="flex items-center justify-center gap-2">
                                <div class="w-24 bg-gray-200 rounded-full h-2">
                                    <div class="h-2 rounded-full {{ $percentage >= 75 ? 'bg-green-500' : ($percentage >= 50 ? 'bg-yellow-500' : 'bg-red-500') }}"></div>
                                </div>
                                <span class="text-sm font-semibold {{ $percentage >= 75 ? 'text-green-600' : ($percentage >= 50 ? 'text-yellow-600' : 'text-red-600') }}">
                                    {{ $percentage }}%
                                </span>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <p class="text-gray-500 text-lg font-medium">Tidak ada data kegiatan</p>
                                <p class="text-gray-400 text-sm mt-1">Silakan pilih periode lain atau tambah kegiatan baru</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
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
</div>

@endsection
