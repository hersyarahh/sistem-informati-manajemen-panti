@extends('layouts.app-admin')

@section('title', 'Tambah User')

@section('content')
<div class="space-y-6">

    <div>
        <h1 class="text-2xl font-bold text-gray-800">Tambah User</h1>
        <p class="text-sm text-gray-500">Lengkapi data pengguna baru</p>
    </div>

    <form action="{{ route('admin.users.store') }}" method="POST" class="bg-white rounded-xl shadow p-6 space-y-5">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                <input type="text" name="name" value="{{ old('name') }}"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-gray-300">
                @error('name')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
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
                        <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                            {{ $role->label }}
                        </option>
                    @endforeach
                </select>
                @error('role_id')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Telepon</label>
                <input type="text" name="phone" value="{{ old('phone') }}"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-gray-300">
                @error('phone')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
            <textarea name="address" rows="3"
                      class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-gray-300">{{ old('address') }}</textarea>
            @error('address')
                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="border-t pt-5">
            <h2 class="text-sm font-semibold text-gray-700 mb-3">Data Keluarga (khusus role Keluarga)</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Lansia</label>
                    <select name="lansia_id"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-gray-300">
                        <option value="">Pilih lansia</option>
                        @foreach ($lansias as $lansia)
                            <option value="{{ $lansia->id }}" {{ old('lansia_id') == $lansia->id ? 'selected' : '' }}>
                                {{ $lansia->nama_lengkap }}
                            </option>
                        @endforeach
                    </select>
                    @error('lansia_id')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Hubungan</label>
                    <input type="text" name="hubungan" value="{{ old('hubungan') }}"
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-gray-300"
                           placeholder="Anak / Cucu / Wali">
                    @error('hubungan')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mt-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap Keluarga</label>
                    <input type="text" name="keluarga_nama_lengkap" value="{{ old('keluarga_nama_lengkap', old('name')) }}"
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-gray-300">
                    @error('keluarga_nama_lengkap')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">No. Telepon Keluarga</label>
                    <input type="text" name="keluarga_no_telp" value="{{ old('keluarga_no_telp', old('phone')) }}"
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-gray-300">
                    @error('keluarga_no_telp')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mt-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email Keluarga</label>
                    <input type="email" name="keluarga_email" value="{{ old('keluarga_email', old('email')) }}"
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-gray-300">
                    @error('keluarga_email')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Keluarga</label>
                    <input type="text" name="keluarga_alamat" value="{{ old('keluarga_alamat', old('address')) }}"
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-gray-300">
                    @error('keluarga_alamat')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
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

</div>
@endsection
