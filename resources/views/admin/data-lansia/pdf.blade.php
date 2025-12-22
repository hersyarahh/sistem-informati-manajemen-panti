<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Data Lansia</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h2 { margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; }
        td { padding: 6px; border-bottom: 1px solid #ccc; }
    </style>
</head>
<body>

<h2>Data Lengkap Lansia</h2>

<table>
    <tr><td>Nama</td><td>{{ $lansia->nama_lengkap }}</td></tr>
    <tr><td>NIK</td><td>{{ $lansia->nik }}</td></tr>
    <tr><td>Jenis Kelamin</td><td>{{ $lansia->jenis_kelamin }}</td></tr>
    <tr><td>Tanggal Masuk</td><td>{{ $lansia->tanggal_masuk }}</td></tr>
    <tr><td>Status</td><td>{{ $lansia->status }}</td></tr>
    <tr><td>Alamat</td><td>{{ $lansia->alamat_asal }}</td></tr>
    <tr><td>Kondisi</td><td>{{ $lansia->kondisi_kesehatan }}</td></tr>

    <tr><td colspan="2"><strong>Kontak Darurat</strong></td></tr>
    <tr><td>Nama</td><td>{{ $lansia->kontak_darurat_nama }}</td></tr>
    <tr><td>Telepon</td><td>{{ $lansia->kontak_darurat_telp }}</td></tr>
    <tr><td>Hubungan</td><td>{{ $lansia->kontak_darurat_hubungan }}</td></tr>
</table>

</body>
</html>
