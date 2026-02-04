@extends('layouts.app-karyawan')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-xl shadow p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
            <div>
                <h2 class="text-lg font-semibold text-gray-800">Distribusi Kondisi Lansia</h2>
                <p class="text-sm text-gray-500">Berdasarkan status kesehatan terkini</p>
            </div>
        </div>

        <div class="h-[320px]">
            <canvas id="kondisiChart"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
    (function () {
        const ctx = document.getElementById('kondisiChart');
        if (!ctx) return;

        const labels = @json($chartLabels);
        const data = @json($chartData);

        new Chart(ctx, {
            type: 'pie',
            data: {
                labels,
                datasets: [{
                    data,
                    backgroundColor: [
                        'rgba(59, 130, 246, 0.7)',  // Sehat
                        'rgba(234, 179, 8, 0.7)',   // Sakit Ringan
                        'rgba(239, 68, 68, 0.7)',   // Sakit Berat
                        'rgba(168, 85, 247, 0.7)'   // Perawatan Khusus
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
