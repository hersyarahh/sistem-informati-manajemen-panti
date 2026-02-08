@extends('layouts.app-admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold sm:text-3xl">Dashboard Admin</h1>
        <p class="text-gray-600">Selamat datang, Admin Panti</p>
    </div>

    <!-- 4 STATISTICS (1 BARIS) -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-6 xl:grid-cols-4">
        <div class="bg-white p-6 rounded-xl shadow">
            <p class="text-gray-500">Total Lansia</p>
            <h2 class="text-3xl font-bold text-blue-600 mt-2">{{ $totalLansia }}</h2>
        </div>

        <div class="bg-white p-6 rounded-xl shadow">
            <p class="text-gray-500">Total Pekerja Sosial</p>
            <h2 class="text-3xl font-bold text-green-600 mt-2">{{ $totalKaryawan }}</h2>
        </div>

        <div class="bg-white p-6 rounded-xl shadow">
            <p class="text-gray-500">Kegiatan Hari Ini</p>
            <h2 class="text-3xl font-bold text-purple-600 mt-2">{{ $kegiatanHariIni }}</h2>
        </div>

        <div class="bg-white p-6 rounded-xl shadow">
            <p class="text-gray-500">Total Inventaris</p>
            <h2 class="text-3xl font-bold text-orange-600 mt-2">{{ $totalInventaris }}</h2>
        </div>

    </div>

    @php
        $chartLabels = collect($lansiaYearLabels)->values();
        $chartData = collect($lansiaYearCounts)->values();
    @endphp

    <div class="grid grid-cols-1 gap-6">
        <div class="bg-white p-6 rounded-xl shadow">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
                <div>
                    <h2 class="text-lg font-semibold text-gray-800">Total Lansia per Tahun</h2>
                </div>
            </div>

            <div class="h-[260px]">
                <canvas id="lansiaYearChart"></canvas>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
                <div>
                    <h2 class="text-lg font-semibold text-gray-800">Distribusi Kondisi Lansia</h2>
                    <p class="text-sm text-gray-500">Ringkasan kondisi kesehatan</p>
                </div>
            </div>

            <div class="h-[260px]">
                <canvas id="kondisiChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
    (function () {
        const ctx = document.getElementById('lansiaYearChart');
        if (!ctx) return;

        const labels = @json($chartLabels);
        const data = @json($chartData);

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels,
                datasets: [{
                    label: 'Jumlah Lansia',
                    data,
                    backgroundColor: 'rgba(37, 99, 235, 0.2)',
                    borderColor: 'rgba(37, 99, 235, 1)',
                    borderWidth: 2,
                    borderRadius: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: { mode: 'index', intersect: false },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        position: 'right',
                        display: false,
                        grid: {
                            display: false
                        },
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    })();
</script>

<script>
    (function () {
        const ctx = document.getElementById('kondisiChart');
        if (!ctx) return;

        const labels = @json($kondisiChartLabels);
        const data = @json($kondisiChartData);

        new Chart(ctx, {
            type: 'pie',
            data: {
                labels,
                datasets: [{
                    data,
                    backgroundColor: [
                        'rgba(59, 130, 246, 0.7)',
                        'rgba(234, 179, 8, 0.7)',
                        'rgba(239, 68, 68, 0.7)',
                        'rgba(168, 85, 247, 0.7)'
                    ],
                    borderColor: [
                        'rgba(59, 130, 246, 1)',
                        'rgba(234, 179, 8, 1)',
                        'rgba(239, 68, 68, 1)',
                        'rgba(168, 85, 247, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
    })();
</script>
@endsection
