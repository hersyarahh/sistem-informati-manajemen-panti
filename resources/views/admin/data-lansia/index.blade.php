@extends('layouts.app-admin')

@section('title', 'Data Lansia')

@section('content')
<div class="space-y-6">
    
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Data Lansia</h1>
            <p class="text-gray-600 text-sm mt-1">Total: {{ $lansias->total() }} lansia</p>
        </div>
        <a href="{{ route('admin.lansia.create') }}" 
           class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Input Data Baru
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded">
        <div class="flex">
            <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <p class="ml-3 text-sm text-green-700 font-medium">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    <!-- Filter & Search -->
<div class="bg-white rounded-lg shadow p-4">
    <form method="GET" action="{{ route('admin.lansia.index') }}" 
          class="grid grid-cols-1 md:grid-cols-12 gap-3 items-center">

        <!-- Search (dipendekin) -->
        <div class="md:col-span-5">
            <input type="text" 
                   name="search" 
                   value="{{ request('search') }}" 
                   placeholder="Cari nama lansia..."
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg 
                          focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        </div>

        <!-- Status -->
        <div class="md:col-span-2">
            <select name="status"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg 
                           focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="">Semua Status</option>
                <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="keluar" {{ request('status') == 'keluar' ? 'selected' : '' }}>Keluar</option>
                <option value="meninggal" {{ request('status') == 'meninggal' ? 'selected' : '' }}>Meninggal</option>
            </select>
        </div>

        <!-- Kondisi -->
        <!-- <div class="md:col-span-3">
            <select name="kondisi"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg 
                           focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="">Semua Kondisi</option>
                <option value="sehat" {{ request('kondisi') == 'sehat' ? 'selected' : '' }}>Sehat</option>
                <option value="sakit_ringan" {{ request('kondisi') == 'sakit_ringan' ? 'selected' : '' }}>Sakit Ringan</option>
                <option value="sakit_berat" {{ request('kondisi') == 'sakit_berat' ? 'selected' : '' }}>Sakit Berat</option>
                <option value="perawatan_khusus" {{ request('kondisi') == 'perawatan_khusus' ? 'selected' : '' }}>
                    Perawatan Khusus
                </option>
            </select>
        </div> -->

        <!-- Button Cari -->
        <div class="md:col-span-2 flex gap-2">
            <button type="submit"
                    class="w-full px-4 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-800">
                Cari
            </button>

            @if(request('search') || request('status') || request('kondisi'))
            <a href="{{ route('admin.lansia.index') }}"
               class="w-full px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 text-center">
                Reset
            </a>
            @endif
        </div>

    </form>
</div>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">JK</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Umur</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alamat</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Kamar</th>
                        <!-- <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kondisi</th> -->
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($lansias as $index => $lansia)
                    <tr class="hover:bg-gray-50">
                        <!-- Nomor Urut -->
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $lansias->firstItem() + $index }}
                        </td>

                        <!-- Nama -->
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    @if($lansia->foto)
                                        <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $lansia->foto) }}" alt="">
                                    @else
                                        <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                            <span class="text-blue-600 font-bold text-lg">{{ substr($lansia->nama_lengkap, 0, 1) }}</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">{{ $lansia->nama_lengkap }}</p>
                                </div>
                            </div>
                        </td>

                        <!-- Jenis Kelamin -->
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $lansia->jenis_kelamin }}
                        </td>

                        <!-- Umur -->
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $lansia->umur() }} tahun
                            <br>
                            <span class="text-xs text-gray-400">{{ $lansia->tanggal_lahir->format('d/m/Y') }}</span>
                        </td>

                        <!-- Alamat -->
                        <td class="px-4 py-4 text-sm text-gray-600 max-w-xs truncate" title="{{ $lansia->alamat_asal }}">
                            {{ Str::limit($lansia->alamat_asal, 30) }}
                        </td>

                        <!-- No Kamar -->
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                            {{ $lansia->no_kamar ?? '-' }}
                        </td>

                        <!-- Kondisi -->
                        <!-- <td class="px-4 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full
                                @if($lansia->kondisi_kesehatan === 'sehat') bg-green-100 text-green-800
                                @elseif($lansia->kondisi_kesehatan === 'sakit_ringan') bg-yellow-100 text-yellow-800
                                @elseif($lansia->kondisi_kesehatan === 'sakit_berat') bg-orange-100 text-orange-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ ucfirst(str_replace('_', ' ', $lansia->kondisi_kesehatan)) }}
                            </span>
                        </td> -->

                        <!-- Status (Quick Edit) -->
                        <td class="px-4 py-4 whitespace-nowrap">
                            <form action="{{ route('admin.lansia.update-status', $lansia) }}" method="POST" class="status-form">
                                @csrf
                                @method('PATCH')
                                <select name="status" onchange="this.form.submit()" 
                                        class="text-xs font-semibold rounded-full border-0 focus:ring-2 focus:ring-blue-500
                                        @if($lansia->status === 'aktif') bg-green-100 text-green-800
                                        @elseif($lansia->status === 'keluar') bg-gray-100 text-gray-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                    <option value="aktif" {{ $lansia->status === 'aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="keluar" {{ $lansia->status === 'keluar' ? 'selected' : '' }}>Keluar</option>
                                    <option value="meninggal" {{ $lansia->status === 'meninggal' ? 'selected' : '' }}>Meninggal</option>
                                </select>
                            </form>
                        </td>

                        <!-- Aksi -->
                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center gap-2">
                                <!-- Detail -->
                                <a href="{{ route('admin.lansia.show', $lansia) }}" 
                                   class="text-blue-600 hover:text-blue-900" title="Lihat Detail">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </a>

                                <!-- Edit -->
                                <a href="{{ route('admin.lansia.edit', $lansia) }}" 
                                   class="text-yellow-600 hover:text-yellow-900" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>

                                <!-- Hapus -->
                                <form action="{{ route('admin.lansia.destroy', $lansia) }}" method="POST" 
                                      onsubmit="return confirm('Yakin ingin menghapus data {{ $lansia->nama_lengkap }}?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-4 py-8 text-center text-gray-500">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                            </svg>
                            <p class="mt-2">Tidak ada data lansia</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($lansias->hasPages())
        <div class="px-4 py-3 border-t border-gray-200">
            {{ $lansias->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Loading Overlay untuk Status Update -->
<script>
document.querySelectorAll('.status-form').forEach(form => {
    form.addEventListener('submit', function() {
        const overlay = document.createElement('div');
        overlay.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
        overlay.innerHTML = '<div class="bg-white p-4 rounded-lg"><p class="text-gray-700">Memperbarui status...</p></div>';
        document.body.appendChild(overlay);
    });
});
</script>

@endsection