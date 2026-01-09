@extends('layouts.app-admin')

@section('title', 'Pesan Keluarga')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Pesan Keluarga</h1>
            <p class="text-sm text-gray-500">Daftar percakapan keluarga dengan petugas</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-gray-600">
                    <tr>
                        <th class="px-4 py-3 text-left">Keluarga</th>
                        <th class="px-4 py-3 text-left">Lansia</th>
                        <th class="px-4 py-3 text-left">Pesan Terakhir</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse ($threads as $thread)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 font-medium text-gray-800">
                                {{ $thread->keluarga?->name ?? '-' }}
                            </td>
                            <td class="px-4 py-3 text-gray-700">
                                {{ $thread->lansia?->nama_lengkap ?? '-' }}
                            </td>
                            <td class="px-4 py-3 text-gray-600">
                                {{ $thread->latestMessage?->body ?? 'Belum ada pesan.' }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                <a href="{{ route('admin.chat.show', $thread) }}"
                                   class="inline-flex items-center justify-center px-3 py-1.5 bg-blue-600 text-white rounded-lg text-xs hover:bg-blue-700">
                                    Buka
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-6 text-gray-500">
                                Belum ada percakapan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
