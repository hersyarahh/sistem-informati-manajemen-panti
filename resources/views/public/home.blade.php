@extends('layouts.app-public')

@section('content')

<!-- HERO -->
<div id="home" class="relative w-full" style="aspect-ratio: 1890/842;">
    <img src="{{ asset('panti.jpg') }}" class="absolute inset-0 w-full h-full object-cover">

    <div class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center">
        <div class="text-white text-center px-4">
            <h1 class="text-3xl md:text-4xl font-extrabold mb-4">
                Panti Sosial Tresna Werdha Husnul Khotimah
            </h1>
            <p class="text-base md:text-lg max-w-3xl mx-auto">
                Memberikan pelayanan terbaik untuk kesejahteraan para lansia di Pekanbaru.
            </p>
        </div>
    </div>
</div>

<!-- TENTANG KAMI -->
<section id="tentang-kami" class="py-20 bg-gray-50 w-full">
    <div class="w-full px-4 md:px-10 space-y-12">

        <!-- Header -->
        <div class="space-y-3 w-full">
            <h2 class="text-4xl font-bold text-blue-700 text-center">Tentang Kami</h2>
            <p class="text-gray-700 text-center max-w-4xl mx-auto">
                UPT PSTW Husnul Khotimah Pekanbaru memberikan perawatan & layanan harian bagi lansia.
            </p>
        </div>

        <!-- Info Detail -->
        <div class="space-y-12">

            <!-- Status Lembaga & Visi Misi -->
            <div class="grid md:grid-cols-2 gap-8 w-full">
                <div class="bg-white shadow-md rounded-xl p-6">
                    <h3 class="text-xl font-semibold text-blue-600 mb-3">Status Lembaga</h3>
                    <p class="text-gray-700">
                        Berada di bawah naungan Dinas Sosial Provinsi Riau.
                    </p>
                </div>

                <div class="bg-white shadow-md rounded-xl p-6">
                    <h3 class="text-xl font-semibold text-blue-600 mb-3">Visi & Misi</h3>
                    <p class="text-gray-700 mb-2">
                        Visi: Terwujudnya kesejahteraan dan perlindungan sosial bagi lanjut usia.
                    </p>

                    <p class="font-semibold text-gray-700">Misi:</p>
                    <ul class="list-disc list-inside text-gray-700 space-y-1">
                        <li>Meningkatkan kualitas hidup lansia.</li>
                        <li>Meningkatkan sarana prasarana & kerjasama sosial.</li>
                        <li>Pemberdayaan keterampilan lansia.</li>
                    </ul>
                </div>
            </div>

            <!-- Pendirian -->
            <div class="bg-white shadow-md rounded-xl p-6 w-full">
                <h3 class="text-xl font-semibold text-blue-600 mb-3">Pendirian & Akreditasi</h3>
                <p class="text-gray-700">
                    Berdiri berdasarkan SK Menteri Sosial RI No. 32/HUK/Kep/V/1982.
                </p>
            </div>

            <!-- Program -->
            <div class="bg-white shadow-md rounded-xl p-6 w-full">
                <h3 class="text-xl font-semibold text-blue-600 mb-3">Program Layanan</h3>

                <div class="grid md:grid-cols-2 gap-6 w-full">
                    <div class="space-y-4">
                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                            <h4 class="font-semibold text-blue-700">Motivasi & Diagnosis Psikososial</h4>
                            <p class="text-sm text-gray-700">Meningkatkan keberfungsian sosial lansia.</p>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                            <h4 class="font-semibold text-blue-700">Perawatan & Pengasuhan</h4>
                            <p class="text-sm text-gray-700">Pemeriksaan kesehatan dan pengasuhan lansia.</p>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                            <h4 class="font-semibold text-blue-700">Pelatihan Vokasional</h4>
                            <p class="text-sm text-gray-700">Merajut, kerajinan tangan, keterampilan.</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                            <h4 class="font-semibold text-blue-700">Bimbingan Mental</h4>
                            <p class="text-sm text-gray-700">Ceramah, pengajian, pembinaan rohani.</p>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                            <h4 class="font-semibold text-blue-700">Bimbingan Fisik</h4>
                            <p class="text-sm text-gray-700">Senam lansia dan kegiatan jasmani.</p>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                            <h4 class="font-semibold text-blue-700">Bimbingan Sosial</h4>
                            <p class="text-sm text-gray-700">Diskusi, kuis, problem solving.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Struktur Organisasi -->
            <div class="bg-white shadow-md rounded-xl p-6 text-center w-full">
                <h3 class="text-xl font-semibold text-blue-600 mb-3">Struktur Organisasi</h3>
                <img src="{{ asset('images/StrukturOrganisasi.jpg') }}" class="mx-auto rounded-lg shadow-md w-[50%]">
            </div>
        </div>
    </div>
</section>

<!-- DONASI -->
<!-- <section id="donasi" class="py-20 bg-white w-full">
    <div class="w-full px-4 md:px-10 text-center">
        <h2 class="text-3xl font-bold mb-6 text-blue-600">Donasi</h2>
        <p class="text-gray-700 mb-6">Dukungan Anda sangat berarti bagi lansia.</p>

        <a href="{{ route('donasi.index') }}"
           class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            Donasi Sekarang
        </a>
    </div>
</section> -->

<!-- GALERI -->
<section id="galeri" class="py-20 bg-gray-100 w-full">
    <div class="w-full px-4 md:px-10 text-center">
        <h2 class="text-3xl font-bold mb-6 text-blue-600">Galeri</h2>
        <p class="text-gray-700 mb-6">Foto kegiatan lansia.</p>

        <div class="grid md:grid-cols-3 gap-6 w-full">
            <img src="{{ asset('satu.png') }}" class="w-full h-48 object-cover rounded-lg">
            <img src="{{ asset('dua.png') }}" class="w-full h-48 object-cover rounded-lg">
            <img src="{{ asset('tiga.png') }}" class="w-full h-48 object-cover rounded-lg">
        </div>
    </div>
</section>

<!-- KONTAK -->
<section id="kontak" class="py-10 bg-gray-50 w-full">
    <div class="w-full px-4 md:px-10 text-left text-gray-700 text-sm space-y-1">
        <p><strong>Alamat:</strong> Jalan Kaharuddin Nasution No. 116, Pekanbaru</p>
        <p><strong>Email:</strong>
            <a href="mailto:tresnawerdha.riau@gmail.com" class="text-blue-600 hover:underline">
                tresnawerdha.riau@gmail.com
            </a>
        </p>
        <p><strong>Instagram:</strong>
            <a href="https://www.instagram.com/pantisosialrehabilitasilansia/" target="_blank"
               class="text-blue-600 hover:underline">
               UPT PSTW Khusnul Khotimah
            </a>
        </p>
    </div>
</section>

@endsection
