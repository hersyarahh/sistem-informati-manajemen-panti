@extends('layouts.app-admin')

@section('content')
<div class="space-y-6">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold">
            Detail Inventaris & Laporan Operasional
        </h1>

        <a href="{{ route('inventaris.download-laporan', $inventaris->id) }}"
            class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            Download Laporan
        </a>
    </div>

    <!-- CARD DETAIL -->
    <div class="bg-white rounded shadow p-6">
        <h2 class="text-lg font-semibold mb-4 border-b pb-2">
            Informasi Inventaris
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div>
                <p class="text-sm text-gray-500">Nama Barang</p>
                <p class="font-medium">{{ $inventaris->nama_barang }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Kategori</p>
                <p class="font-medium">{{ $inventaris->kategori }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Jenis</p>
                <p class="font-medium">{{ $inventaris->jenis }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Jumlah</p>
                <p class="font-medium">{{ $inventaris->jumlah }} unit</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Kondisi</p>
                <p class="font-medium">{{ $inventaris->kondisi }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Lokasi</p>
                <p class="font-medium">{{ $inventaris->lokasi }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Sumber Dana</p>
                <p class="font-medium">{{ $inventaris->sumber_dana }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Tahun</p>
                <p class="font-medium">{{ $inventaris->tahun_pengadaan }}</p>
            </div>

            <div class="md:col-span-2">
                <p class="text-sm text-gray-500">Keterangan</p>
                <p class="font-medium">
                    {{ $inventaris->keterangan ?? '-' }}
                </p>
            </div>

        </div>
    </div>

</div>
@endsection
