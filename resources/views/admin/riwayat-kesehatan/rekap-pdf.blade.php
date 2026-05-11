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
            padding-bottom: 35mm;
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

        .riwayat-card {
            border: 1px solid #d1d5db;
            border-radius: 6px;
            margin-top: 14px;
            overflow: hidden;
        }

        .riwayat-header {
            background: #2563eb;
            color: #ffffff;
            padding: 8px 10px;
            font-weight: bold;
            font-size: 10pt;
        }

        table.detail-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        table.detail-table td {
            border: 1px solid #e5e7eb;
            padding: 8px 10px;
            vertical-align: top;
            font-size: 10.5pt;
            word-wrap: break-word;
        }

        .detail-label {
            width: 28%;
            background: #f9fafb;
            font-weight: bold;
            color: #4b5563;
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
            background: #ffffff;
            padding: 12px 10px 8px;
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
    @foreach ($riwayats as $index => $riwayat)
        <div class="riwayat-card">
            <div class="riwayat-header">
                Pemeriksaan #{{ $index + 1 }} - {{ $riwayat->tanggal_periksa?->format('d/m/Y') ?? '-' }}
            </div>
            <table class="detail-table">
                <tr>
                    <td class="detail-label">Tanggal Periksa</td>
                    <td>{{ $riwayat->tanggal_periksa?->format('d/m/Y') ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="detail-label">Jenis Pemeriksaan</td>
                    <td>{{ $riwayat->jenis_pemeriksaan ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="detail-label">Keluhan</td>
                    <td>{{ $riwayat->keluhan ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="detail-label">Diagnosa</td>
                    <td>{{ $riwayat->diagnosa ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="detail-label">Tindakan</td>
                    <td>{{ $riwayat->tindakan ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="detail-label">Resep Obat</td>
                    <td>{{ $riwayat->resep_obat ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="detail-label">Penanggung Jawab</td>
                    <td>{{ $riwayat->nama_petugas ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="detail-label">Catatan</td>
                    <td>{{ $riwayat->catatan ?? '-' }}</td>
                </tr>
            </table>
        </div>
    @endforeach
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
