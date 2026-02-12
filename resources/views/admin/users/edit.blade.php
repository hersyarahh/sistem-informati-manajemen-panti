@extends('layouts.app-admin')

@section('title', 'Edit User')

@section('content')
<div class="space-y-6">

    <div>
        <h1 class="text-2xl font-bold text-gray-800">Edit User</h1>
        <p class="text-sm text-gray-500">Perbarui data pengguna</p>
    </div>

    <form action="{{ route('admin.users.update', $user) }}" method="POST" class="bg-white rounded-xl shadow p-6 space-y-5">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-gray-300">
                @error('name')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-gray-300">
                @error('email')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                <select name="role_id"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-gray-300">
                    <option value="">Pilih role</option>
                    @foreach ($roles as $role)
                        @php $roleLabel = $role->name === 'karyawan' ? 'Pekerja Sosial' : $role->label; @endphp
                        <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                            {{ $roleLabel }}
                        </option>
                    @endforeach
                </select>
                @error('role_id')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" inputmode="numeric" pattern="[0-9]*"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-gray-300">
                @error('phone')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password (opsional)</label>
                <input type="password" name="password"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-gray-300">
                @error('password')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                <input type="password" name="password_confirmation"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-gray-300">
            </div>
        </div>

        <div class="flex items-center gap-3">
            <button type="submit"
                    class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Simpan
            </button>
            <a href="{{ route('admin.users.index') }}"
               class="px-5 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                Batal
            </a>
        </div>
    </form>

    <div class="bg-white rounded-xl shadow p-6 space-y-4">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-lg font-semibold text-gray-800">Status Akun</h2>
                <p class="text-sm text-gray-500">
                    Status saat ini:
                    <span class="{{ $user->is_active ? 'text-green-600' : 'text-red-600' }} font-medium">
                        {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </p>
            </div>
            <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST">
                @csrf
                @method('PATCH')
                <button type="submit"
                        class="px-5 py-2 rounded-lg text-white {{ $user->is_active ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700' }}"
                        onclick="return confirm('{{ $user->is_active ? 'Nonaktifkan akun ini?' : 'Aktifkan akun ini?' }}')">
                    {{ $user->is_active ? 'Nonaktifkan Akun' : 'Aktifkan Akun' }}
                </button>
            </form>
        </div>
        @if ($errors->has('user'))
            <p class="text-sm text-red-600">{{ $errors->first('user') }}</p>
        @endif
    </div>

</div>
@endsection
