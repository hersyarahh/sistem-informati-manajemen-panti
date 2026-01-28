@extends('layouts.app-admin')

@section('title', 'Data Inventaris')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Data Inventaris</h1>
            <p class="text-sm text-gray-500">Total: {{ $inventaris->count() }} inventaris</p>
        </div>

        <a href="{{ route('admin.data-inventaris.create') }}" 
           class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Tambah Inventaris
        </a>
    </div>

    {{-- Filter --}}
<div class="bg-white rounded-xl shadow p-4 mb-6">
    <form method="GET"
          action="{{ route('admin.data-inventaris.index') }}"
          class="flex flex-wrap gap-3 items-center">

        {{-- Search --}}
        <input type="text"
               name="search"
               placeholder="Cari nama barang..."
               value="{{ request('search') }}"
               class="w-full md:w-1/3 px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-gray-300">

        {{-- Sumber Dana --}}
        <select name="sumber_dana"
                    class="min-w-[180px] px-4 py-2 border border-gray-300 rounded-lg
                        focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Semua Sumber Dana</option>
            <option value="APBD" {{ request('sumber_dana')=='APBD'?'selected':'' }}>APBD</option>
            <option value="Donatur" {{ request('sumber_dana')=='Donatur'?'selected':'' }}>Donatur</option>
            <option value="CSR" {{ request('sumber_dana')=='CSR'?'selected':'' }}>CSR</option>
        </select>

        {{-- Kategori --}}
        <select name="kategori"
                class="px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-gray-300">
            <option value="">Semua Kategori</option>
            <option value="Sarana/Prasarana" {{ request('kategori')=='Sarana'?'selected':'' }}>Sarana/Prasarana</option>
            <option value="Gedung" {{ request('kategori')=='Gedung'?'selected':'' }}>Gedung</option>
            <option value="Alat Bantu" {{ request('kategori')=='Alat Bantu'?'selected':'' }}>Alat Bantu</option>
        </select>

        {{-- Button --}}
        <div class="flex gap-2">
            <button type="submit"
                    class="px-5 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-800">
                Cari
            </button>

            @if(request('search') || request('sumber_dana') || request('kategori'))
                <a href="{{ route('admin.data-inventaris.index') }}"
                   class="px-5 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 text-center">
                    Reset
                </a>
            @endif
        </div>

    </form>
</div>


    {{-- Tabel --}}
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-600">
                <tr>
                    <th class="px-4 py-3 text-left">No</th>
                    <th class="px-4 py-3 text-left">Nama Barang</th>
                    <th class="px-4 py-3 text-left">Kategori</th>
                    <!-- <th class="px-4 py-3 text-left">Jenis</th> -->
                    <th class="px-4 py-3 text-center">Jumlah</th>
                    <th class="px-4 py-3 text-center">Kondisi</th>
                    <th class="px-4 py-3 text-left">Sumber Dana</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @forelse ($inventaris as $item)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3">{{ $loop->iteration }}</td>
                    <td class="px-4 py-3 font-medium text-gray-800">
                        {{ $item->nama_barang }}
                    </td>
                    <td class="px-4 py-3">{{ $item->kategori }}</td>
                    <!-- <td class="px-4 py-3">{{ $item->jenis }}</td> -->
                    <td class="px-4 py-3 text-center">{{ $item->jumlah }}</td>
                    <td class="px-4 py-3 text-center">
                        <span class="px-3 py-1 rounded-full text-xs
                            @if($item->kondisi == 'Baik') bg-green-100 text-green-700
                            @elseif($item->kondisi == 'Rusak Ringan') bg-yellow-100 text-yellow-700
                            @else bg-red-100 text-red-700
                            @endif">
                            {{ $item->kondisi }}
                        </span>
                    </td>
                    <td class="px-4 py-3">{{ $item->sumber_dana }}</td>
                    <!-- <td class="px-4 py-3 text-center">{{ $item->tahun_pengadaan }}</td>
                    <td class="px-4 py-3">{{ $item->lokasi }}</td> -->
                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex items-center gap-2">
                            <!-- Detail -->
                            <a href="{{ route('admin.data-inventaris.show', $item->id) }}" 
                            class="text-blue-600 hover:text-blue-900" title="Lihat Detail">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </a>

                            <!-- Edit -->
                            <a href="{{ route('admin.data-inventaris.edit', $item->id) }}" 
                            class="text-yellow-600 hover:text-yellow-900" title="Edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>

                            <!-- Hapus -->
                            <form action="{{ route('admin.data-inventaris.destroy', $item->id) }}" method="POST" 
                                onsubmit="return confirm('Yakin ingin menghapus data {{ $item->nama_barang }}?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="text-center py-6 text-gray-500">
                        Data inventaris belum tersedia
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
