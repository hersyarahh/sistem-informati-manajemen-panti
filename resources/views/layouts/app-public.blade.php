<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'UPT PSTW Husnul Khotimah')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        html {
            scroll-behavior: smooth; /* Smooth scroll ke section */
        }
    </style>
</head>

<body class="bg-gray-100">

    <!-- NAVBAR UMUM -->
    <nav class="bg-white shadow fixed w-full z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

            <!-- LOGO KIRI -->
            <h1 class="text-xl font-bold text-blue-700">
                PSTW Husnul Khotimah
            </h1>

            <!-- MENU + LOGIN DIKANAN -->
            <div class="hidden md:flex items-center space-x-8 text-gray-700 font-medium ml-auto">
                <!-- Link absolute ke Home + anchor -->
                <a href="{{ url('/#home') }}" class="hover:text-blue-700">Home</a>
                <a href="{{ url('/#tentang-kami') }}" class="hover:text-blue-700">Tentang Kami</a>
                <!--<a href="{{ url('/#donasi') }}" class="hover:text-blue-700">Donasi</a>-->
                <a href="{{ url('/#galeri') }}" class="hover:text-blue-700">Galeri</a>

                <!-- LOGIN -->
                <a href="/login" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 shadow"> Login </a>
            </div>

            <!-- BURGER (MOBILE) -->
            <button id="public-menu-toggle"
                class="md:hidden inline-flex items-center justify-center rounded-md p-2 text-gray-700 hover:bg-gray-100"
                aria-controls="public-mobile-menu" aria-expanded="false">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

        </div>

        <!-- MOBILE MENU -->
        <div id="public-mobile-menu" class="md:hidden hidden border-t border-gray-100">
            <div class="px-6 py-4 flex flex-col gap-3 text-gray-700 font-medium">
                <a href="{{ url('/#home') }}" class="hover:text-blue-700">Home</a>
                <a href="{{ url('/#tentang-kami') }}" class="hover:text-blue-700">Tentang Kami</a>
                <!--<a href="{{ url('/#donasi') }}" class="hover:text-blue-700">Donasi</a>-->
                <a href="{{ url('/#galeri') }}" class="hover:text-blue-700">Galeri</a>
                <a href="/login"
                    class="inline-flex items-center justify-center bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 shadow">
                    Login
                </a>
            </div>
        </div>
    </nav>

<!-- KONTEN -->
<div class="pt-20">
    @yield('content')
</div>

<script>
    (function () {
        const toggle = document.getElementById('public-menu-toggle');
        const menu = document.getElementById('public-mobile-menu');

        if (!toggle || !menu) {
            return;
        }

        toggle.addEventListener('click', () => {
            const isHidden = menu.classList.contains('hidden');
            menu.classList.toggle('hidden', !isHidden);
            toggle.setAttribute('aria-expanded', isHidden ? 'true' : 'false');
        });
    })();
</script>

</body>
</html>
