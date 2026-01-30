@extends('layouts.app-admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="flex flex-col h-full w-full">

    <div class="px-4 pt-6 sm:px-8">
        <h1 class="text-2xl font-bold sm:text-3xl">Dashboard Admin</h1>
        <p class="text-gray-600 mb-6">Selamat datang, Admin Panti</p>
    </div>

    <div class="px-4 pb-6 sm:px-8">

        <!-- 4 STATISTICS (1 BARIS) -->
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-6 xl:grid-cols-4">

            <div class="bg-white p-6 rounded-xl shadow">
                <p class="text-gray-500">Total Lansia</p>
                <h2 class="text-3xl font-bold text-blue-600 mt-2">{{ $totalLansia }}</h2>
            </div>

            <!-- <div class="bg-white p-6 rounded-xl shadow">
                <p class="text-gray-500">Total Karyawan</p>
                <h2 class="text-3xl font-bold text-green-600 mt-2">{{ $totalKaryawan }}</h2>
            </div> -->

            <div class="bg-white p-6 rounded-xl shadow">
                <p class="text-gray-500">Kegiatan Hari Ini</p>
                <h2 class="text-3xl font-bold text-purple-600 mt-2">{{ $kegiatanHariIni }}</h2>
            </div>

            <div class="bg-white p-6 rounded-xl shadow">
                <p class="text-gray-500">Total Keluarga</p>
                <h2 class="text-3xl font-bold text-orange-600 mt-2">{{ $totalKeluarga }}</h2>
            </div>

        </div>

    </div>

</div>
@endsection
