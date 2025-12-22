@extends('layouts.app-public')

@section('content')

<!-- Hero Section -->
<div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white py-16">
    <div class="max-w-7xl mx-auto px-6 text-center">
        <h1 class="text-4xl font-bold mb-4">Berbagi Kebahagiaan untuk Lansia</h1>
        <p class="text-xl text-blue-100 max-w-2xl mx-auto">
            Donasi Anda sangat berarti untuk kesejahteraan para lansia di Panti Husnul Khotimah
        </p>
    </div>
</div>

<!-- Success Message -->
@if(session('success'))
<div class="max-w-7xl mx-auto px-6 mt-6">
    <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Main Content -->
<div class="max-w-7xl mx-auto px-6 py-16">
    <div class="bg-white rounded-lg shadow-lg p-6 md:p-8 max-w-3xl mx-auto">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Form Donasi</h2>
        
        <form action="{{ route('donasi.store') }}" method="POST" enctype="multipart/form-data" id="donasiForm">
            @csrf
            
            <!-- Jenis Donasi -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-3">Jenis Donasi</label>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    <label class="relative cursor-pointer">
                        <input type="radio" name="jenis_donasi" value="uang" class="peer sr-only" required checked>
                        <div class="border-2 border-gray-200 rounded-lg p-4 text-center peer-checked:border-blue-600 peer-checked:bg-blue-50 transition-all">
                            <svg class="w-8 h-8 mx-auto text-gray-400 peer-checked:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-xs font-medium mt-2 block">Uang</span>
                        </div>
                    </label>
                    <label class="relative cursor-pointer">
                        <input type="radio" name="jenis_donasi" value="barang" class="peer sr-only" required>
                        <div class="border-2 border-gray-200 rounded-lg p-4 text-center peer-checked:border-blue-600 peer-checked:bg-blue-50 transition-all">
                            <svg class="w-8 h-8 mx-auto text-gray-400 peer-checked:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                            <span class="text-xs font-medium mt-2 block">Barang</span>
                        </div>
                    </label>
                    <label class="relative cursor-pointer">
                        <input type="radio" name="jenis_donasi" value="makanan" class="peer sr-only" required>
                        <div class="border-2 border-gray-200 rounded-lg p-4 text-center peer-checked:border-blue-600 peer-checked:bg-blue-50 transition-all">
                            <svg class="w-8 h-8 mx-auto text-gray-400 peer-checked:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            <span class="text-xs font-medium mt-2 block">Makanan</span>
                        </div>
                    </label>
                    <label class="relative cursor-pointer">
                        <input type="radio" name="jenis_donasi" value="lainnya" class="peer sr-only" required>
                        <div class="border-2 border-gray-200 rounded-lg p-4 text-center peer-checked:border-blue-600 peer-checked:bg-blue-50 transition-all">
                            <svg class="w-8 h-8 mx-auto text-gray-400 peer-checked:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            <span class="text-xs font-medium mt-2 block">Lainnya</span>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Nominal (untuk donasi uang) -->
            <div id="nominalSection">
                <label class="block text-sm font-semibold text-gray-700 mb-3">Pilih Nominal</label>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3 mb-4">
                    <button type="button" class="quick-amount border-2 border-gray-200 rounded-lg p-3 text-center hover:border-blue-600 hover:bg-blue-50 transition-all font-semibold" data-amount="50000">Rp 50.000</button>
                    <button type="button" class="quick-amount border-2 border-gray-200 rounded-lg p-3 text-center hover:border-blue-600 hover:bg-blue-50 transition-all font-semibold" data-amount="100000">Rp 100.000</button>
                    <button type="button" class="quick-amount border-2 border-gray-200 rounded-lg p-3 text-center hover:border-blue-600 hover:bg-blue-50 transition-all font-semibold" data-amount="200000">Rp 200.000</button>
                    <button type="button" class="quick-amount border-2 border-gray-200 rounded-lg p-3 text-center hover:border-blue-600 hover:bg-blue-50 transition-all font-semibold" data-amount="500000">Rp 500.000</button>
                    <button type="button" class="quick-amount border-2 border-gray-200 rounded-lg p-3 text-center hover:border-blue-600 hover:bg-blue-50 transition-all font-semibold" data-amount="1000000">Rp 1.000.000</button>
                    <button type="button" id="customBtn" class="border-2 border-blue-600 text-blue-600 rounded-lg p-3 text-center hover:bg-blue-50 transition-all font-semibold">Nominal Lain</button>
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nominal Donasi (Rp)</label>
                    <input type="number" name="nominal" id="nominalInput" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Masukkan nominal" min="0">
                </div>
            </div>

            <!-- Deskripsi Barang (untuk donasi barang/makanan) -->
            <div id="deskripsiSection" class="hidden mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Donasi *</label>
                <textarea name="deskripsi_barang" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Jelaskan barang/makanan yang akan didonasikan"></textarea>
            </div>

            <!-- Data Donatur -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap *</label>
                    <input type="text" name="nama_donatur" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Nama Anda">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="email@example.com">
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                <input type="tel" name="no_telp" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="08xxxxxxxxxx">
            </div>

            <!-- Upload Bukti -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Upload Bukti Transfer (Opsional)</label>
                <input type="file" name="bukti_donasi" accept="image/*" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG (Max 2MB)</p>
            </div>

            <!-- Catatan -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Pesan/Catatan (Opsional)</label>
                <textarea name="catatan" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Tulis pesan Anda..."></textarea>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-blue-600 text-white py-4 rounded-lg font-semibold hover:bg-blue-700 transition-colors text-lg">
                Kirim Donasi
            </button>
        </form>
    </div>

    <!-- Informasi Rekening -->
    <div class="bg-white rounded-lg shadow-lg p-6 mt-10 max-w-3xl mx-auto">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Informasi Rekening</h3>
        <div class="space-y-4">
            <div class="border-l-4 border-blue-600 pl-4">
                <p class="text-sm text-gray-600">Bank BCA</p>
                <p class="text-lg font-bold text-gray-800">1234567890</p>
                <p class="text-sm text-gray-600">a.n. Panti Husnul Khotimah</p>
            </div>
            <div class="border-l-4 border-green-600 pl-4">
                <p class="text-sm text-gray-600">Bank Mandiri</p>
                <p class="text-lg font-bold text-gray-800">0987654321</p>
                <p class="text-sm text-gray-600">a.n. Panti Husnul Khotimah</p>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript (sama seperti sebelumnya) -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const jenisDonasi = document.querySelectorAll('input[name="jenis_donasi"]');
    const nominalSection = document.getElementById('nominalSection');
    const deskripsiSection = document.getElementById('deskripsiSection');
    const nominalInput = document.getElementById('nominalInput');
    const quickAmounts = document.querySelectorAll('.quick-amount');
    const customBtn = document.getElementById('customBtn');

    jenisDonasi.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'uang') {
                nominalSection.classList.remove('hidden');
                deskripsiSection.classList.add('hidden');
                nominalInput.required = true;
                document.querySelector('textarea[name="deskripsi_barang"]').required = false;
            } else {
                nominalSection.classList.add('hidden');
                deskripsiSection.classList.remove('hidden');
                nominalInput.required = false;
                document.querySelector('textarea[name="deskripsi_barang"]').required = true;
            }
        });
    });

    quickAmounts.forEach(btn => {
        btn.addEventListener('click', function() {
            quickAmounts.forEach(b => b.classList.remove('border-blue-600', 'bg-blue-50'));
            this.classList.add('border-blue-600', 'bg-blue-50');
            nominalInput.value = this.dataset.amount;
        });
    });

    customBtn.addEventListener('click', function() {
        quickAmounts.forEach(b => b.classList.remove('border-blue-600', 'bg-blue-50'));
        nominalInput.focus();
    });

    nominalInput.addEventListener('input', function() {
        quickAmounts.forEach(b => b.classList.remove('border-blue-600', 'bg-blue-50'));
    });
});
</script>

@endsection
