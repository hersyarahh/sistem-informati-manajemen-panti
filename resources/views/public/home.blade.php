@extends('layouts.app-public')

@section('content')

    <!-- HERO -->
    <div id="home" class="relative w-full min-h-[60vh] sm:min-h-[70vh] lg:min-h-[80vh]">
        <img src="{{ asset('panti.jpg') }}" class="absolute inset-0 w-full h-full object-cover">

        <div class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center">
            <div class="text-white text-center px-4 sm:px-6">
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold mb-4">
                    Panti Sosial Tresna Werdha Husnul Khotimah
                </h1>
                <p class="text-sm sm:text-base md:text-lg max-w-3xl mx-auto">
                    Memberikan pelayanan terbaik untuk kesejahteraan para lansia di Pekanbaru.
                </p>
            </div>
        </div>
    </div>

    <!-- TENTANG KAMI -->
<section id="tentang-kami" class="py-12 sm:py-16 lg:py-20 bg-gray-50 w-full">
    <div class="w-full px-4 sm:px-6 md:px-10 space-y-10 sm:space-y-12">

        <!-- Header -->
        <div class="space-y-3 w-full">
            <h2 class="text-3xl sm:text-4xl font-bold text-blue-700 text-center">Tentang Kami</h2>
            <p class="text-gray-700 text-center max-w-4xl mx-auto">
                UPT PSTW Husnul Khotimah Pekanbaru memberikan perawatan & layanan harian bagi lansia.
            </p>
        </div>

        <!-- Info Detail -->
        <div class="space-y-10 sm:space-y-12">

            <!-- Status Lembaga & Visi Misi -->
            <div class="grid md:grid-cols-2 gap-6 sm:gap-8 w-full">
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
            <div class="bg-white shadow-md rounded-xl p-5 sm:p-6 w-full">
                <h3 class="text-xl font-semibold text-blue-600 mb-3">Pendirian & Akreditasi</h3>
                <p class="text-gray-700">
                    Berdiri berdasarkan SK Menteri Sosial RI No. 32/HUK/Kep/V/1982.
                </p>
            </div>

            <!-- Program -->
            <div class="bg-white shadow-md rounded-xl p-5 sm:p-6 w-full">
                <h3 class="text-xl font-semibold text-blue-600 mb-3">Program Layanan</h3>

                <div class="grid md:grid-cols-2 gap-4 sm:gap-6 w-full">
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
            <div class="bg-white shadow-md rounded-xl p-5 sm:p-6 text-center w-full">
                <h3 class="text-xl font-semibold text-blue-600 mb-3">Struktur Organisasi</h3>
                <img src="{{ asset('images/StrukturOrganisasi.jpg') }}"
                    class="mx-auto rounded-lg shadow-md w-full sm:w-3/4 lg:w-1/2">
            </div>
        </div>
    </div>
</section>


    <!-- GALERI -->
    <section id="galeri" class="py-12 sm:py-16 lg:py-20 bg-gray-100 w-full">
        <div class="w-full px-4 sm:px-6 md:px-10 text-center">
            <h2 class="text-2xl sm:text-3xl font-bold mb-4 sm:mb-6 text-blue-600">Galeri</h2>
            <p class="text-gray-700 mb-6">Foto kegiatan lansia.</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 w-full">
                <img src="{{ asset('satu.png') }}" class="w-full h-48 sm:h-56 object-cover rounded-lg">
                <img src="{{ asset('dua.png') }}" class="w-full h-48 sm:h-56 object-cover rounded-lg">
                <img src="{{ asset('tiga.png') }}" class="w-full h-48 sm:h-56 object-cover rounded-lg">
            </div>
        </div>
    </section>

    <!-- FOOTER / KONTAK -->
    <footer id="kontak" class="bg-gray-50 w-full border-t border-gray-200">
        <div class="mx-auto w-full max-w-5xl px-4 sm:px-6 md:px-10 py-12">
            <div class="flex flex-col items-center text-center text-gray-700 text-sm space-y-6">
                <div class="flex items-center justify-center gap-6">
                    <a href="https://wa.me/6281230371118" target="_blank"
                        class="text-green-500 hover:text-green-600" aria-label="WhatsApp">
                        <svg class="h-9 w-9" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M12 2a10 10 0 0 0-8.66 15l-1.1 4.02a1 1 0 0 0 1.23 1.23l4.02-1.1A10 10 0 1 0 12 2zm0 18a8 8 0 0 1-4.07-1.12 1 1 0 0 0-.79-.09l-2.7.74.74-2.7a1 1 0 0 0-.09-.79A8 8 0 1 1 12 20zm4.3-5.1c-.23-.12-1.36-.67-1.57-.74-.21-.07-.37-.12-.52.12-.15.23-.6.74-.73.89-.13.15-.27.17-.5.06-.23-.12-1-.37-1.9-1.19-.7-.62-1.17-1.38-1.31-1.61-.14-.23-.01-.35.1-.47.1-.1.23-.27.35-.4.12-.13.15-.23.23-.38.08-.15.04-.29-.02-.4-.06-.12-.52-1.26-.72-1.72-.19-.46-.38-.4-.52-.4-.13 0-.29-.02-.44-.02-.15 0-.4.06-.61.29-.21.23-.8.78-.8 1.9s.82 2.2.93 2.35c.12.15 1.62 2.47 3.92 3.46.55.24.98.38 1.32.49.55.17 1.05.14 1.44.09.44-.07 1.36-.56 1.55-1.1.19-.54.19-1 .13-1.1-.06-.1-.21-.17-.44-.29z"/>
                        </svg>
                    </a>
                    <a href="https://www.instagram.com/pantisosialrehabilitasilansia/" target="_blank"
                        class="hover:opacity-90" aria-label="Instagram">
                        <svg class="h-8 w-8" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <defs>
                                <linearGradient id="igGradient" x1="0" y1="0" x2="1" y2="1">
                                    <stop offset="0%" stop-color="#feda75" />
                                    <stop offset="50%" stop-color="#d62976" />
                                    <stop offset="100%" stop-color="#4f5bd5" />
                                </linearGradient>
                            </defs>
                            <path stroke="url(#igGradient)" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 3h10a4 4 0 014 4v10a4 4 0 01-4 4H7a4 4 0 01-4-4V7a4 4 0 014-4z" />
                            <path stroke="url(#igGradient)" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7h.01" />
                            <path stroke="url(#igGradient)" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8a4 4 0 100 8 4 4 0 000-8z" />
                        </svg>
                    </a>
                </div>

                <div class="space-y-2">
                    <p>Jalan Kaharuddin Nasution No. 116, Pekanbaru</p>
                    {{-- <p><strong>Email:</strong>
                        <a href="mailto:tresnawerdha.riau@gmail.com" class="text-blue-600 hover:underline">
                            tresnawerdha.riau@gmail.com
                        </a>
                    </p>
                    <p><strong>Instagram:</strong>
                        <a href="https://www.instagram.com/pantisosialrehabilitasilansia/" target="_blank"
                            class="text-blue-600 hover:underline">
                            UPT PSTW Khusnul Khotimah
                        </a>
                    </p> --}}
                </div>
            </div>
        </div>
    </footer>

@endsection
