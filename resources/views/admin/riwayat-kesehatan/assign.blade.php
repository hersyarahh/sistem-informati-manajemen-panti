@extends('layouts.app-admin')

@section('title', 'Tentukan Pekerja Sosial')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Tentukan Pekerja Sosial</h1>
            <p class="text-sm text-gray-500">Pilih pekerja sosial dan lansia yang ditugaskan</p>
        </div>
        <a href="{{ route('admin.riwayat-kesehatan.index') }}"
           class="text-blue-600 hover:text-blue-700 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded">
            <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.riwayat-kesehatan.assign.select') }}" class="bg-white rounded-lg shadow p-4" id="assignFilterForm">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-12 gap-3 items-center">
            <div class="md:col-span-5">
                <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Pekerja Sosial</label>
                <select name="staff_id"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg
                               focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        onchange="this.form.submit()">
                    <option value="">-- Pilih Pekerja Sosial --</option>
                    @foreach ($staffs as $staff)
                        <option value="{{ $staff->id }}" {{ (string) $staff->id === (string) ($selectedStaff?->id) ? 'selected' : '' }}>
                            {{ $staff->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="md:col-span-5">
                <label class="block text-sm font-medium text-gray-700 mb-1">Filter No. Kamar</label>
                <select name="no_kamar"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg
                               focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        onchange="submitAssignFilter()">
                    <option value="">Semua Kamar</option>
                    @foreach ($rooms as $room)
                        <option value="{{ $room }}" {{ (string) $room === (string) $selectedRoom ? 'selected' : '' }}>
                            {{ $room }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="md:col-span-2 flex gap-2 items-end pt-6">
                <button type="submit"
                        class="w-full px-4 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-800">
                    Tampilkan
                </button>

                @if ($selectedRoom || $selectedStaff)
                <a href="{{ route('admin.riwayat-kesehatan.assign.reset') }}"
                   class="w-full px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 text-center">
                    Reset
                </a>
                @endif
            </div>
        </div>
    </form>

    <form method="POST" action="{{ route('admin.riwayat-kesehatan.assign.store') }}" class="bg-white rounded-lg shadow">
        @csrf
        <input type="hidden" name="staff_id" value="{{ $selectedStaff?->id }}">

        <div class="p-4 border-b">
            <h2 class="text-lg font-semibold text-gray-800">Daftar Lansia Aktif</h2>
            <p class="text-sm text-gray-500">
                @if ($selectedStaff)
                    Menugaskan lansia untuk: <span class="font-semibold">{{ $selectedStaff->name }}</span>
                @else
                    Pilih pekerja sosial terlebih dahulu untuk mengaktifkan checklist.
                @endif
            </p>
        </div>

        <div class="p-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                @foreach ($lansias as $lansia)
                    <label class="flex items-center gap-3 border rounded-lg px-3 py-2 hover:bg-gray-50">
                        <input type="checkbox"
                               name="lansia_ids[]"
                               value="{{ $lansia->id }}"
                               {{ !$selectedStaff ? 'disabled' : '' }}
                               {{ in_array($lansia->id, $selectedLansiaIds, true) ? 'checked' : '' }}>
                        <span class="text-sm text-gray-700">{{ $lansia->nama_lengkap }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <div class="p-4 border-t flex justify-end gap-3">
            <button type="submit"
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700"
                    {{ $selectedStaff ? '' : 'disabled' }}>
                Simpan Penugasan
            </button>
        </div>
    </form>
</div>

<script>
    function submitAssignFilter() {
        const form = document.getElementById('assignFilterForm');
        if (!form) return;

        // clear previous hidden inputs
        form.querySelectorAll('input[name="selected_lansia_ids[]"]').forEach((el) => el.remove());

        document.querySelectorAll('input[name="lansia_ids[]"]:checked').forEach((checkbox) => {
            const hidden = document.createElement('input');
            hidden.type = 'hidden';
            hidden.name = 'selected_lansia_ids[]';
            hidden.value = checkbox.value;
            form.appendChild(hidden);
        });

        form.submit();
    }
</script>
@endsection
