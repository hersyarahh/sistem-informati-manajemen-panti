<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="m-0 p-0 bg-gray-100">

    <div class="relative flex min-h-screen w-screen">

        <!-- MOBILE OVERLAY -->
        <div id="admin-sidebar-overlay"
            class="fixed inset-0 z-30 bg-black/40 opacity-0 pointer-events-none transition-opacity duration-200 lg:hidden">
        </div>

        <!-- SIDEBAR -->
        <aside id="admin-sidebar"
            class="fixed inset-y-0 left-0 z-40 w-64 -translate-x-full bg-blue-700 text-white flex flex-col min-h-screen transform transition-transform duration-200 ease-out lg:static lg:translate-x-0">

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

                @php $isActive = request()->routeIs('admin.chat.*'); @endphp
                <a href="{{ route('admin.chat.index') }}"
                   class="{{ $navBase }} {{ $isActive ? $navActive : $navInactive }}"
                   @if ($isActive) aria-current="page" @endif>
                    Pesan Keluarga
                </a>

                @php $isActive = request()->routeIs('admin.users.*'); @endphp
                <a href="{{ route('admin.users.index') }}"
                   class="{{ $navBase }} {{ $isActive ? $navActive : $navInactive }}"
                   @if ($isActive) aria-current="page" @endif>
                    Manajemen User
                </a>

                @php $isActive = request()->routeIs('admin.lansia.*'); @endphp
                <a href="{{ route('admin.lansia.index') }}"
                   class="{{ $navBase }} {{ $isActive ? $navActive : $navInactive }}"
                   @if ($isActive) aria-current="page" @endif>
                    Data Lansia
                </a>

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

                <!-- @php $isActive = request()->is('admin/donasi*'); @endphp
                <a href="{{ url('/admin/donasi') }}"
                   class="{{ $navBase }} {{ $isActive ? $navActive : $navInactive }}"
                   @if ($isActive) aria-current="page" @endif>
                    Donasi
                </a> -->
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
        <main class="flex-1 min-h-screen overflow-auto px-4 py-6 sm:px-8 sm:py-8 flex items-start justify-center">
            <div class="w-full max-w-6xl flex flex-col gap-6">
                <div class="flex items-center gap-3 lg:hidden">
                    <button id="admin-sidebar-toggle" type="button"
                        class="inline-flex items-center justify-center rounded-lg bg-white p-2 text-gray-700 shadow hover:bg-gray-50"
                        aria-controls="admin-sidebar" aria-expanded="false">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <span class="text-sm font-semibold text-gray-600">Menu Admin</span>
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

            if (!toggle || !sidebar || !overlay) {
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
                } else if (!sidebar.classList.contains('translate-x-0')) {
                    close();
                }
            });
        })();
    </script>

    <div id="toast-container"
         data-user-id="{{ auth()->id() }}"
         class="fixed right-4 top-4 z-50 space-y-3">
    </div>

    <script>
        (function () {
            const container = document.getElementById('toast-container');
            if (!container) {
                return;
            }

            const currentUserId = Number(container.dataset.userId);
            const chatMessages = document.getElementById('chat-messages');
            const activeThreadId = chatMessages ? Number(chatMessages.dataset.threadId) : null;

            const showToast = ({ title, body, link }) => {
                const toast = document.createElement('div');
                toast.className = 'w-72 sm:w-80 rounded-xl bg-white shadow-lg ring-1 ring-black/10 p-4 flex gap-3';

                const content = document.createElement('div');
                content.className = 'flex-1';

                const heading = document.createElement('p');
                heading.className = 'text-sm font-semibold text-gray-800';
                heading.textContent = title;

                const message = document.createElement('p');
                message.className = 'mt-1 text-sm text-gray-600';
                message.textContent = body;

                content.appendChild(heading);
                content.appendChild(message);

                if (link) {
                    const action = document.createElement('a');
                    action.className = 'mt-2 inline-flex text-sm font-medium text-blue-600 hover:text-blue-700';
                    action.href = link;
                    action.textContent = 'Buka pesan';
                    content.appendChild(action);
                }

                const close = document.createElement('button');
                close.type = 'button';
                close.className = 'text-gray-400 hover:text-gray-600';
                close.textContent = 'x';
                close.addEventListener('click', () => toast.remove());

                toast.appendChild(content);
                toast.appendChild(close);
                container.appendChild(toast);

                setTimeout(() => {
                    toast.remove();
                }, 6000);
            };

            const handleMessage = (event) => {
                if (event.sender_id === currentUserId) {
                    return;
                }

                if (activeThreadId && Number(event.thread_id) === activeThreadId) {
                    return;
                }

                showToast({
                    title: `Pesan baru dari ${event.sender_name || 'Keluarga'}`,
                    body: event.body || 'Pesan baru masuk.',
                    link: `/admin/chat/${event.thread_id}`,
                });
            };

            let subscribed = false;
            const subscribe = () => {
                if (subscribed || !window.Echo) {
                    return subscribed;
                }

                window.Echo.private('chat.admin')
                    .listen('MessageSent', handleMessage);

                subscribed = true;
                return true;
            };

            if (!subscribe()) {
                const interval = setInterval(() => {
                    if (subscribe()) {
                        clearInterval(interval);
                    }
                }, 200);
            }
        })();
    </script>
</body>

</html>
