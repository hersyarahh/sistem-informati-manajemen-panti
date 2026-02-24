@extends('layouts.app-admin')

@section('title', 'Manajemen User')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Manajemen User</h1>
            <p class="text-sm text-gray-500">Total: {{ $users->count() }} user</p>
        </div>

        <a href="{{ route('admin.users.create') }}"
           class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-white transition-colors hover:bg-blue-700">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Tambah User
        </a>
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

    <div class="bg-white rounded-xl shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-xs sm:text-sm">
                <thead class="bg-gray-50 text-gray-600">
                    <tr>
                        <th class="px-3 py-2 text-left sm:px-4 sm:py-3">No</th>
                        <th class="px-3 py-2 text-left sm:px-4 sm:py-3">Nama</th>
                        <th class="px-3 py-2 text-left sm:px-4 sm:py-3 hidden sm:table-cell">Email</th>
                        <th class="px-3 py-2 text-left sm:px-4 sm:py-3">Role</th>
                        <th class="px-3 py-2 text-left sm:px-4 sm:py-3 hidden md:table-cell"></th>
                        <th class="px-3 py-2 text-center sm:px-4 sm:py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse ($users as $user)
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 py-2 sm:px-4 sm:py-3">{{ $loop->iteration }}</td>
                            <td class="px-3 py-2 font-medium text-gray-800 sm:px-4 sm:py-3">
                                {{ $user->name }}
                                <div class="mt-1 text-xs text-gray-500 sm:hidden">
                                    {{ $user->email }}
                                </div>
                            </td>
                            <td class="px-3 py-2 sm:px-4 sm:py-3 hidden sm:table-cell">
                                {{ $user->email }}
                            </td>
                            <td class="px-3 py-2 sm:px-4 sm:py-3">
                                <span class="inline-flex items-center rounded-full bg-blue-50 px-2 py-1 text-[10px] text-blue-700 sm:px-3 sm:text-xs">
                                    {{ $user->role?->name === 'karyawan' ? 'Pekerja Sosial' : ($user->role?->label ?? '-') }}
                                </span>
                            </td>
                            <td class="px-3 py-2 sm:px-4 sm:py-3 hidden md:table-cell"></td>
                            <td class="px-3 py-2 sm:px-4 sm:py-4 whitespace-nowrap text-xs sm:text-sm font-medium">
                                <div class="flex items-center justify-center gap-1.5 sm:gap-2">
                                    @if ($user->isAdmin())
                                        <span class="text-xs text-gray-400">-</span>
                                    @else
                                        <a href="{{ route('admin.users.edit', $user) }}"
                                           class="inline-flex items-center justify-center rounded-md p-1 text-yellow-600 hover:bg-yellow-50 hover:text-yellow-900 sm:p-1.5"
                                           title="Edit">
                                            <svg class="h-4 w-4 sm:h-5 sm:w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus user {{ $user->name }}?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center justify-center rounded-md p-1 text-red-600 hover:bg-red-50 hover:text-red-900 sm:p-1.5"
                                                title="Hapus">
                                                <svg class="h-4 w-4 sm:h-5 sm:w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                onclick="return confirm('{{ $user->is_active ? 'Nonaktifkan akun ini?' : 'Aktifkan akun ini?' }}')"
                                                class="inline-flex items-center rounded-full px-2 py-1 text-[10px] sm:px-3 sm:text-xs {{ $user->is_active ? 'bg-red-50 text-red-700 hover:bg-red-100' : 'bg-green-50 text-green-700 hover:bg-green-100' }}"
                                                title="{{ $user->is_active ? 'Nonaktifkan akun' : 'Aktifkan akun' }}">
                                                {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-6 text-gray-500">
                                Data user belum tersedia
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
