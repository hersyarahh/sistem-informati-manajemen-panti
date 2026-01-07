<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Inventaris</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11pt;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px solid #2563eb;
            padding-bottom: 10px;
        }

        .header h1 {
            margin: 0;
            font-size: 18pt;
            color: #1e40af;
        }

        .info-box {
            background: #f3f4f6;
            padding: 12px;
            margin-bottom: 20px;
            border-left: 4px solid #2563eb;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 8px;
            border: 1px solid #e5e7eb;
        }

        .label {
            width: 30%;
            font-weight: bold;
            background: #f9fafb;
        }

        .footer {
            margin-top: 30px;
            font-size: 9pt;
            text-align: center;
            color: #6b7280;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>LAPORAN INVENTARIS & OPERASIONAL</h1>
    <p>Panti Sosial Lansia</p>
</div>

<div class="info-box">
    <table>
        <tr>
            <td class="label">Nama Barang</td>
            <td>{{ $inventaris->nama_barang }}</td>
        </tr>
        <tr>
            <td class="label">Kategori</td>
            <td>{{ $inventaris->kategori }}</td>
        </tr>
        <tr>
            <td class="label">Jenis</td>
            <td>{{ $inventaris->jenis }}</td>
        </tr>
        <tr>
            <td class="label">Jumlah</td>
            <td>{{ $inventaris->jumlah }} unit</td>
        </tr>
        <tr>
            <td class="label">Kondisi</td>
            <td>{{ $inventaris->kondisi }}</td>
        </tr>
        <tr>
            <td class="label">Lokasi</td>
            <td>{{ $inventaris->lokasi }}</td>
        </tr>
        <tr>
            <td class="label">Sumber Dana</td>
            <td>{{ $inventaris->sumber_dana }}</td>
        </tr>
        <tr>
            <td class="label">Tahun Pengadaan</td>
            <td>{{ $inventaris->tahun_pengadaan }}</td>
        </tr>
        <tr>
            <td class="label">Keterangan</td>
            <td>{{ $inventaris->keterangan ?? '-' }}</td>
        </tr>
    </table>
</div>

<p>
    Laporan ini dibuat berdasarkan data inventaris yang dipilih
    melalui sistem manajemen inventaris Panti Sosial Lansia.
</p>

<div class="footer">
    Dicetak pada {{ now()->timezone('Asia/Jakarta')->format('d F Y, H:i') }} WIB
</div>

</body>
</html>
