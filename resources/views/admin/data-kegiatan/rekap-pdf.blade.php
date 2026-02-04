<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekap Kegiatan Lansia</title>
    <style>
        @page {
            margin: 20mm 15mm;
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 11pt;
            color: #333;
            line-height: 1.4;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 3px solid #2563eb;
        }
        
        .header h1 {
            margin: 0;
            font-size: 20pt;
            color: #1e40af;
            font-weight: bold;
        }
        
        .header h2 {
            margin: 5px 0 0 0;
            font-size: 14pt;
            color: #666;
            font-weight: normal;
        }
        
        .info-box {
            background: #f3f4f6;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            border-left: 4px solid #2563eb;
        }
        
        .info-box table {
            width: 100%;
        }
        
        .info-box td {
            padding: 5px 0;
        }
        
        .info-box .label {
            font-weight: bold;
            width: 150px;
            color: #555;
        }
        
        .stats-grid {
            display: table;
            width: 100%;
            margin-bottom: 25px;
            border-spacing: 10px 0;
        }
        
        .stat-card {
            display: table-cell;
            width: 33.33%;
            background: #f9fafb;
            padding: 15px;
            text-align: center;
            border-radius: 5px;
            border: 1px solid #e5e7eb;
        }
        
        .stat-card .label {
            font-size: 9pt;
            color: #6b7280;
            text-transform: uppercase;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .stat-card .value {
            font-size: 24pt;
            font-weight: bold;
            color: #1e40af;
        }
        
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        
        table.data-table thead {
            background: #2563eb;
            color: white;
        }
        
        table.data-table th {
            padding: 10px 8px;
            text-align: left;
            font-weight: bold;
            font-size: 10pt;
            border: 1px solid #1e40af;
        }
        
        table.data-table td {
            padding: 8px;
            border: 1px solid #e5e7eb;
            font-size: 10pt;
        }
        
        table.data-table tbody tr:nth-child(even) {
            background: #f9fafb;
        }
        
        table.data-table tbody tr:hover {
            background: #f3f4f6;
        }
        
        .text-center {
            text-align: center;
        }
        
        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 9pt;
            font-weight: bold;
        }
        
        .badge-senam {
            background: #dbeafe;
            color: #1e40af;
        }
        
        .badge-penyuluhan {
            background: #d1fae5;
            color: #065f46;
        }
        
        .badge-pemeriksaan {
            background: #fee2e2;
            color: #991b1b;
        }
        
        .badge-sosial {
            background: #e9d5ff;
            color: #6b21a8;
        }
        
        .progress-bar {
            width: 100px;
            height: 10px;
            background: #e5e7eb;
            border-radius: 5px;
            display: inline-block;
            position: relative;
            margin-right: 5px;
            vertical-align: middle;
        }
        
        .progress-fill {
            height: 100%;
            border-radius: 5px;
            position: absolute;
            left: 0;
            top: 0;
        }
        
        .progress-green { background: #10b981; }
        .progress-yellow { background: #f59e0b; }
        .progress-red { background: #ef4444; }
        
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 9pt;
            color: #6b7280;
            padding: 10px;
            border-top: 1px solid #e5e7eb;
        }
        
        .no-data {
            text-align: center;
            padding: 40px;
            color: #9ca3af;
            font-style: italic;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>REKAP KEGIATAN LANSIA</h1>
        <h2>Laporan Kehadiran dan Statistik Kegiatan</h2>
    </div>

    <!-- Info Laporan -->
    <div class="info-box">
        <table>
            <tr>
                <td class="label">Periode Laporan:</td>
                <td>{{ $periodeLabel }}</td>
            </tr>
            @if($jenis)
            <tr>
                <td class="label">Jenis Kegiatan:</td>
                <td>{{ $jenis }}</td>
            </tr>
            @endif
            <tr>
                <td class="label">Tanggal Cetak:</td>
                <td>{{ now()->timezone('Asia/Jakarta')->format('d F Y, H:i') }} WIB </td>
            </tr>
        </table>
    </div>

    <!-- Tabel Data -->
    @if($kegiatans->count() > 0)
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 15%">Tanggal</th>
                <th style="width: 35%">Nama Kegiatan</th>
                <th style="width: 15%">Jenis</th>
                <th style="width: 10%" class="text-center">Hadir</th>
                <th style="width: 20%" class="text-center">Persentase</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kegiatans as $index => $kegiatan)
            @php
                $persentase = $kegiatan->total_lansia > 0 ? round(($kegiatan->total_hadir / $kegiatan->total_lansia) * 100, 1) : 0;
                $progressClass = $persentase >= 75 ? 'progress-green' : ($persentase >= 50 ? 'progress-yellow' : 'progress-red');
            @endphp
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $kegiatan->tanggal->format('d M Y') }}</td>
                <td>{{ $kegiatan->nama_kegiatan }}</td>
                <td>
                    <span class="badge badge-{{ strtolower($kegiatan->jenis_kegiatan) }}">
                        {{ $kegiatan->jenis_kegiatan }}
                    </span>
                </td>
                <td class="text-center">
                    <strong>{{ $kegiatan->total_hadir }}</strong> / {{ $kegiatan->total_lansia }}
                </td>
                <td class="text-center">
                    <div class="progress-bar">
                        <div class="progress-fill {{ $progressClass }}" style="width: {{ $persentase }}%"></div>
                    </div>
                    <strong>{{ $persentase }}%</strong>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="no-data">
        Tidak ada data kegiatan untuk periode yang dipilih
    </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <p>Dokumen ini dicetak secara otomatis dari Sistem Informasi Upt.Pstw Husnul Khotimah</p>
    </div>
</body>
</html>
