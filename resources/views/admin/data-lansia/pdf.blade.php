<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Data Lansia</title>
    <style>
        @page { margin: 20mm 15mm; }

        body {
            font-family: Arial, sans-serif;
            font-size: 11pt;
            color: #333;
            line-height: 1.45;
        }

        .header {
            text-align: center;
            margin-bottom: 18px;
            padding-bottom: 12px;
            border-bottom: 3px solid #2563eb;
        }
        .header h1 {
            margin: 0;
            font-size: 20pt;
            color: #1e40af;
            font-weight: bold;
            letter-spacing: .3px;
        }
        .header h2 {
            margin: 5px 0 0 0;
            font-size: 12pt;
            color: #666;
            font-weight: normal;
        }

        .info-box {
            background: #f3f4f6;
            padding: 12px 14px;
            margin-bottom: 14px;
            border-radius: 6px;
            border-left: 4px solid #2563eb;
        }
        .info-box table { width: 100%; border-collapse: collapse; }
        .info-box td { padding: 3px 0; vertical-align: top; }
        .info-box .label { font-weight: bold; width: 160px; color: #555; }

        .section-title {
            margin-top: 14px;
            margin-bottom: 8px;
            font-weight: bold;
            font-size: 12pt;
            color: #1e40af;
        }

        .card {
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            overflow: hidden;
            margin-bottom: 12px;
        }

        table.list-table {
            width: 100%;
            border-collapse: collapse;
        }
        table.list-table td {
            padding: 9px 12px;
            border-bottom: 1px solid #e5e7eb;
            vertical-align: top;
            font-size: 10.8pt;
        }
        table.list-table tr:last-child td { border-bottom: none; }

        td.k {
            width: 30%;
            background: #f9fafb;
            color: #6b7280;
            font-weight: bold;
        }
        td.v {
            width: 70%;
            color: #111827;
        }

        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 9pt;
            font-weight: bold;
            text-transform: uppercase;
        }
        .badge-aktif { background: #dbeafe; color: #1e40af; }
        .badge-nonaktif { background: #fee2e2; color: #991b1b; }
        .badge-default { background: #e5e7eb; color: #374151; }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0; right: 0;
            text-align: center;
            font-size: 9pt;
            color: #6b7280;
            padding: 10px 0;
            border-top: 1px solid #e5e7eb;
        }

        .muted { color: #6b7280; }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header">
        <h1>DATA LENGKAP LANSIA</h1>
        <h2>Laporan Identitas & Administrasi</h2>
    </div>

    <!-- Info Laporan -->
    <div class="info-box">
        <table>
            <tr>
                <td class="label">Tanggal Cetak</td>
                <td>: {{ now()->timezone('Asia/Jakarta')->format('d F Y, H:i') }} WIB</td>
            </tr>
            <tr>
                <td class="label">ID Data (opsional)</td>
                <td class="muted">: #{{ $lansia->id ?? '-' }}</td>
            </tr>
        </table>
    </div>

    <!-- Identitas Lansia -->
    <div class="section-title">Identitas Lansia</div>
    <div class="card">
        <table class="list-table">
            <tr>
                <td class="k">Nama Lengkap</td>
                <td class="v">{{ $lansia->nama_lengkap }}</td>
            </tr>
            <tr>
                <td class="k">NIK</td>
                <td class="v">{{ $lansia->nik }}</td>
            </tr>
            <tr>
                <td class="k">Jenis Kelamin</td>
                <td class="v">{{ $lansia->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
            </tr>
            <tr>
                <td class="k">Tanggal Masuk</td>
                <td class="v">{{ \Carbon\Carbon::parse($lansia->tanggal_masuk)->format('d/m/Y') }}</td>
            </tr>
        </table>
    </div>

    <!-- Administrasi & Penempatan -->
    <div class="section-title">Administrasi & Penempatan</div>
    <div class="card">
        <table class="list-table">
            <tr>
                <td class="k">No. Kamar</td>
                <td class="v">{{ $lansia->no_kamar ?? '-' }}</td>
            </tr>
            <tr>
                <td class="k">Alamat Asal</td>
                <td class="v">{{ $lansia->alamat_asal ?? '-' }}</td>
            </tr>
        </table>
    </div>

    <!-- Kontak Darurat -->
    <div class="section-title">Kontak Darurat / Keluarga</div>
    <div class="card">
        <table class="list-table">
            <tr>
                <td class="k">Nama</td>
                <td class="v">{{ $lansia->kontak_darurat_nama ?? '-' }}</td>
            </tr>
            <tr>
                <td class="k">Telepon</td>
                <td class="v">{{ $lansia->kontak_darurat_telp ?? '-' }}</td>
            </tr>
            <tr>
                <td class="k">Hubungan</td>
                <td class="v">{{ $lansia->kontak_darurat_hubungan ?? '-' }}</td>
            </tr>
            <tr>
                <td class="k">Alamat Kontak</td>
                <td class="v">{{ $lansia->kontak_darurat_alamat ?? '-' }}</td>
            </tr>
        </table>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Dokumen ini dicetak secara otomatis dari Sistem Informasi Upt.Pstw Husnul Khotimah</p>
    </div>

</body>
</html>
