<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="icon" href="data:,">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="m-0 p-0 bg-gray-100 overflow-hidden">

    <div class="relative h-screen w-screen">

        <!-- MOBILE OVERLAY -->
        <div id="admin-sidebar-overlay"
            class="fixed inset-0 z-30 bg-black/40 opacity-0 pointer-events-none transition-opacity duration-200 lg:hidden">
        </div>

        <!-- SIDEBAR -->
        <aside id="admin-sidebar"
            class="fixed inset-y-0 left-0 z-40 w-64 -translate-x-full bg-blue-700 text-white flex flex-col h-screen transform transition-transform duration-200 ease-out lg:translate-x-0">

            <!-- TITLE -->
            <div class="px-5 py-6">
                <h2 class="text-xl font-bold mb-10">Menu Admin</h2>
            </div>

            <!-- NAV LINKS -->
            <nav class="flex flex-col space-y-4 px-5 flex-1">
                @php
                    $navBase = 'flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition';
                    $navActive = 'bg-blue-800 text-white shadow';
                    $navInactive = 'text-blue-100 hover:bg-blue-600 hover:text-white';
                @endphp

                @php $isActive = request()->routeIs('admin.dashboard'); @endphp
                <a href="{{ route('admin.dashboard') }}"
                   class="{{ $navBase }} {{ $isActive ? $navActive : $navInactive }}"
                   @if ($isActive) aria-current="page" @endif>
                    Dashboard
                </a>

                @php $isActive = request()->routeIs('admin.users.*'); @endphp
                <a href="{{ route('admin.users.index') }}"
                   class="{{ $navBase }} {{ $isActive ? $navActive : $navInactive }}"
                   @if ($isActive) aria-current="page" @endif>
                    Manajemen User
                </a>

                @php $isActive = request()->routeIs('admin.pekerja-sosial.*'); @endphp
                <a href="{{ route('admin.pekerja-sosial.index') }}"
                   class="{{ $navBase }} {{ $isActive ? $navActive : $navInactive }}"
                   @if ($isActive) aria-current="page" @endif>
                    Data Pekerja Sosial
                </a>

                @php
                    $isActive = request()->routeIs('admin.lansia.*');
                    $isSubActive = request()->routeIs('admin.riwayat-kesehatan.*');
                    $subVisibility = $isSubActive ? 'block' : 'hidden group-hover:block';
                @endphp
                <div class="group">
                    <a href="{{ route('admin.lansia.index') }}"
                       class="{{ $navBase }} {{ $isActive ? $navActive : $navInactive }}"
                       @if ($isActive) aria-current="page" @endif>
                        Data Lansia
                    </a>
                    <div class="pl-6 mt-2">
                        <a href="{{ route('admin.riwayat-kesehatan.index') }}"
                           class="{{ $navBase }} {{ $isSubActive ? $navActive : $navInactive }} {{ $subVisibility }} text-xs px-3 py-2"
                           @if ($isSubActive) aria-current="page" @endif>
                            Riwayat Kesehatan
                        </a>
                    </div>
                </div>

                @php $isActive = request()->routeIs('admin.kegiatan.*'); @endphp
                <a href="{{ route('admin.kegiatan.index') }}"
                   class="{{ $navBase }} {{ $isActive ? $navActive : $navInactive }}"
                   @if ($isActive) aria-current="page" @endif>
                    Data Kegiatan
                </a>

                @php $isActive = request()->routeIs('admin.data-inventaris.*'); @endphp
                <a href="{{ route('admin.data-inventaris.index') }}"
                   class="{{ $navBase }} {{ $isActive ? $navActive : $navInactive }}"
                   @if ($isActive) aria-current="page" @endif>
                    Inventaris
                </a>

            </nav>

            <!-- LOGOUT BUTTON -->
            <div class="px-5 pb-4"> 
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full bg-red-500 hover:bg-red-600 text-white p-3 rounded-xl text-center">
                        Logout
                    </button>
                </form>
            </div>

        </aside>


        <!-- MAIN CONTENT -->
        <main class="h-screen overflow-auto lg:pl-64">
            <div class="mx-auto w-full max-w-6xl px-4 py-6 sm:px-8 sm:py-8 flex flex-col gap-6">
                <div class="fixed left-4 top-4 z-50 flex items-center gap-3 lg:static lg:z-auto lg:hidden">
                    <button id="admin-sidebar-toggle" type="button"
                        class="inline-flex items-center justify-center rounded-lg bg-white p-2 text-gray-700 shadow hover:bg-gray-50"
                        aria-controls="admin-sidebar" aria-expanded="false">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <span id="admin-sidebar-label" class="hidden text-sm font-semibold text-gray-600">Menu Admin</span>
                </div>
                @yield('content')
            </div>
        </main>

    </div>

    <script>
        (function () {
            const toggle = document.getElementById('admin-sidebar-toggle');
            const sidebar = document.getElementById('admin-sidebar');
            const overlay = document.getElementById('admin-sidebar-overlay');
            const label = document.getElementById('admin-sidebar-label');
            const pageTitle = document.querySelector('main h1');

            if (!toggle || !sidebar || !overlay || !label) {
                return;
            }

            const openClass = 'translate-x-0';
            const closedClass = '-translate-x-full';

            const open = () => {
                sidebar.classList.add(openClass);
                sidebar.classList.remove(closedClass);
                overlay.classList.remove('opacity-0', 'pointer-events-none');
                overlay.classList.add('opacity-100');
                document.body.style.overflow = 'hidden';
                toggle.setAttribute('aria-expanded', 'true');
            };

            const close = () => {
                sidebar.classList.remove(openClass);
                sidebar.classList.add(closedClass);
                overlay.classList.add('opacity-0', 'pointer-events-none');
                overlay.classList.remove('opacity-100');
                document.body.style.overflow = '';
                toggle.setAttribute('aria-expanded', 'false');
            };

            const toggleSidebar = () => {
                if (sidebar.classList.contains(openClass)) {
                    close();
                } else {
                    open();
                }
            };

            toggle.addEventListener('click', toggleSidebar);
            overlay.addEventListener('click', close);
            sidebar.addEventListener('click', (event) => {
                if (window.innerWidth >= 1024) {
                    return;
                }

                const target = event.target;
                if (target instanceof HTMLElement && target.closest('a')) {
                    close();
                }
            });

            window.addEventListener('resize', () => {
                if (window.innerWidth >= 1024) {
                    sidebar.classList.add('translate-x-0');
                    sidebar.classList.remove('-translate-x-full');
                    overlay.classList.add('opacity-0', 'pointer-events-none');
                    overlay.classList.remove('opacity-100');
                    document.body.style.overflow = '';
                    toggle.setAttribute('aria-expanded', 'false');
                pageTitle?.classList.remove('pl-8');
                } else if (!sidebar.classList.contains('translate-x-0')) {
                    close();
                    pageTitle?.classList.add('pl-8');
                }
            });

            if (window.innerWidth < 1024) {
                pageTitle?.classList.add('pl-8');
            }
        })();
    </script>

</body>

</html>
