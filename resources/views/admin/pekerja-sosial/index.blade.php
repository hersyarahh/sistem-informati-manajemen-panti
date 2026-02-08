@extends('layouts.app-admin')

@section('title', 'Data Pekerja Sosial')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Data Pekerja Sosial</h1>
            <p class="text-sm text-gray-500">Total: {{ $pekerjaSosials->total() }} pekerja sosial</p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.pekerja-sosial.rekap') }}"
               class="inline-flex items-center justify-center px-5 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition-colors">
                Rekap Pekerja Sosial
            </a>
            <a href="{{ route('admin.pekerja-sosial.create') }}"
               class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-white transition-colors hover:bg-blue-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Tambah Pekerja Sosial
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->has('user'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
            {{ $errors->first('user') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow p-4">
        <form method="GET" action="{{ route('admin.pekerja-sosial.index') }}"
              class="grid grid-cols-1 md:grid-cols-12 gap-3 items-center">
            <div class="md:col-span-6">
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Cari nama pekerja sosial..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg
                              focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <div class="md:col-span-3">
                <select name="status_pegawai"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg
                               focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Semua Status</option>
                    <option value="Tetap" {{ request('status_pegawai') == 'Tetap' ? 'selected' : '' }}>Tetap</option>
                    <option value="Honorer" {{ request('status_pegawai') == 'Honorer' ? 'selected' : '' }}>Honorer</option>
                    <option value="Kontrak" {{ request('status_pegawai') == 'Kontrak' ? 'selected' : '' }}>Kontrak</option>
                </select>
            </div>

            <div class="md:col-span-3 flex gap-2">
                <button type="submit"
                        class="w-full px-4 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-800">
                    Cari
                </button>
                @if(request()->filled('search') || request()->filled('status_pegawai'))
                    <a href="{{ route('admin.pekerja-sosial.index') }}"
                       class="w-full px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 text-center">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">JK</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Pegawai</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mulai Bertugas</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($pekerjaSosials as $index => $pekerjaSosial)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $pekerjaSosials->firstItem() + $index }}
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        @if($pekerjaSosial->foto)
                                            <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $pekerjaSosial->foto) }}" alt="">
                                        @else
                                            <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                                <span class="text-blue-600 font-bold text-lg">{{ substr($pekerjaSosial->nama_lengkap, 0, 1) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">{{ $pekerjaSosial->nama_lengkap }}</p>
                                        <p class="text-xs text-gray-500">{{ $pekerjaSosial->alamat ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ $pekerjaSosial->jenis_kelamin ?? '-' }}
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ $pekerjaSosial->status_pegawai ?? '-' }}
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ $pekerjaSosial->tanggal_mulai_bertugas?->format('d/m/Y') ?? '-' }}
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.pekerja-sosial.show', $pekerjaSosial) }}"
                                       class="text-blue-600 hover:text-blue-900" title="Detail">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.pekerja-sosial.edit', $pekerjaSosial) }}"
                                       class="text-yellow-600 hover:text-yellow-900" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.pekerja-sosial.destroy', $pekerjaSosial) }}" method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus pekerja sosial {{ $pekerjaSosial->nama_lengkap }}?')" class="inline">
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
                            <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                                Data pekerja sosial belum tersedia
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pekerjaSosials->hasPages())
        <div class="px-4 py-3 border-t border-gray-200">
            {{ $pekerjaSosials->links('pagination.admin') }}
        </div>
        @endif
    </div>
</div>
@endsection
