<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekap Kesehatan Lansia</title>
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

        .no-data {
            text-align: center;
            padding: 40px;
            color: #9ca3af;
            font-style: italic;
        }

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
    </style>
</head>
<body>
    <div class="header">
        <h1>REKAP KESEHATAN LANSIA</h1>
        <h2>Laporan Pemeriksaan Kesehatan</h2>
    </div>

    <div class="info-box">
        <table>
            <tr>
                <td class="label">Nama Lansia:</td>
                <td>{{ $lansia->nama_lengkap }}</td>
            </tr>
            <tr>
                <td class="label">No. Kamar:</td>
                <td>{{ $lansia->no_kamar ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Tanggal Cetak:</td>
                <td>{{ now()->timezone('Asia/Jakarta')->format('d F Y, H:i') }} WIB</td>
            </tr>
        </table>
    </div>

    @if($riwayats->count() > 0)
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 12%">Tanggal</th>
                <th style="width: 18%">Jenis</th>
                <th style="width: 18%">Keluhan</th>
                <th style="width: 18%">Diagnosa</th>
                <th style="width: 18%">Tindakan</th>
                <th style="width: 16%">Petugas</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($riwayats as $riwayat)
                <tr>
                    <td>{{ $riwayat->tanggal_periksa?->format('d/m/Y') ?? '-' }}</td>
                    <td>{{ $riwayat->jenis_pemeriksaan ?? '-' }}</td>
                    <td>{{ $riwayat->keluhan ?? '-' }}</td>
                    <td>{{ $riwayat->diagnosa ?? '-' }}</td>
                    <td>{{ $riwayat->tindakan ?? '-' }}</td>
                    <td>{{ $riwayat->nama_petugas ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="no-data">
        Belum ada riwayat kesehatan.
    </div>
    @endif

    <div class="footer">
        <p>Dokumen ini dicetak secara otomatis dari Sistem Informasi Upt.Pstw Husnul Khotimah</p>
    </div>
</body>
</html>
