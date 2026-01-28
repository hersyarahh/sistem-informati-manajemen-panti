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

                @php $isActive = request()->is('admin/donasi*'); @endphp
                <a href="{{ url('/admin/donasi') }}"
                   class="{{ $navBase }} {{ $isActive ? $navActive : $navInactive }}"
                   @if ($isActive) aria-current="page" @endif>
                    Donasi
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

    <div id="admin-chat-widget"
         data-user-id="{{ auth()->id() }}"
         data-user-name="{{ auth()->user()->name }}"
         data-open="false"
         data-active-thread-id=""
         class="fixed bottom-5 right-5 z-40 flex flex-col items-end gap-3">
        <div id="admin-chat-widget-panel"
             class="hidden w-[20rem] sm:w-96 overflow-hidden rounded-2xl bg-white shadow-2xl ring-1 ring-black/10">
            <div id="admin-chat-widget-list" class="flex flex-col">
                <div class="flex items-center justify-between border-b border-gray-100 px-4 py-3">
                    <div>
                        <p class="text-sm font-semibold text-gray-800">Pesan Keluarga</p>
                        <p class="text-xs text-gray-500">Pilih keluarga untuk dibalas</p>
                    </div>
                    <button id="admin-chat-widget-close" type="button" class="text-gray-400 hover:text-gray-600">
                        <span class="sr-only">Tutup</span>
                        x
                    </button>
                </div>
                <div id="admin-chat-widget-threads" class="max-h-64 overflow-auto p-3 space-y-2"></div>
                <div id="admin-chat-widget-empty" class="hidden px-4 py-6 text-center text-sm text-gray-500">
                    Belum ada pesan dari keluarga.
                </div>
            </div>

            <div id="admin-chat-widget-chat" class="hidden flex flex-col">
                <div class="flex items-center justify-between bg-blue-600 px-4 py-3 text-white">
                    <div>
                        <p id="admin-chat-widget-title" class="text-sm font-semibold">Keluarga</p>
                        <p id="admin-chat-widget-subtitle" class="text-xs text-blue-100">Detail lansia</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <button id="admin-chat-widget-back" type="button" class="text-blue-100 hover:text-white">
                            <span class="sr-only">Kembali</span>
                            &lt;
                        </button>
                        <button id="admin-chat-widget-close-chat" type="button" class="text-blue-100 hover:text-white">
                            <span class="sr-only">Tutup</span>
                            x
                        </button>
                    </div>
                </div>
                <div id="admin-chat-widget-messages"
                     class="max-h-64 overflow-auto bg-gray-50 p-3 space-y-3 text-sm">
                </div>
                <form id="admin-chat-widget-form" class="flex items-center gap-2 border-t border-gray-100 bg-white p-3">
                    <input id="admin-chat-widget-input" type="text"
                           class="flex-1 rounded-full border border-gray-200 px-4 py-2 text-sm focus:border-blue-400 focus:outline-none focus:ring focus:ring-blue-100"
                           placeholder="Tulis pesan..." autocomplete="off" />
                    <button type="submit"
                            class="rounded-full bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
                        Kirim
                    </button>
                </form>
            </div>
        </div>

        <button id="admin-chat-widget-button" type="button"
                class="relative flex h-14 w-14 items-center justify-center rounded-full bg-blue-600 text-white shadow-lg transition hover:bg-blue-700"
                aria-label="Buka chat">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M8 10h8m-8 4h5m9-2a9 9 0 11-3.6-7.2L21 4l-1.8 4.6A8.96 8.96 0 0121 12z"/>
            </svg>
            <span id="admin-chat-widget-badge"
                  class="absolute -right-1 -top-1 hidden min-w-[1.25rem] rounded-full bg-red-500 px-1 text-center text-[10px] font-semibold leading-5 text-white">
                0
            </span>
        </button>
    </div>

    <div id="toast-container"
         data-user-id="{{ auth()->id() }}"
         class="fixed right-4 top-4 z-50 space-y-3">
    </div>

    <script>
        (function () {
            const widget = document.getElementById('admin-chat-widget');
            const toastContainer = document.getElementById('toast-container');
            if (!widget || !toastContainer) {
                return;
            }

            const button = document.getElementById('admin-chat-widget-button');
            const panel = document.getElementById('admin-chat-widget-panel');
            const listView = document.getElementById('admin-chat-widget-list');
            const chatView = document.getElementById('admin-chat-widget-chat');
            const threadsContainer = document.getElementById('admin-chat-widget-threads');
            const emptyState = document.getElementById('admin-chat-widget-empty');
            const closeList = document.getElementById('admin-chat-widget-close');
            const closeChat = document.getElementById('admin-chat-widget-close-chat');
            const backButton = document.getElementById('admin-chat-widget-back');
            const messagesContainer = document.getElementById('admin-chat-widget-messages');
            const form = document.getElementById('admin-chat-widget-form');
            const input = document.getElementById('admin-chat-widget-input');
            const title = document.getElementById('admin-chat-widget-title');
            const subtitle = document.getElementById('admin-chat-widget-subtitle');
            const badge = document.getElementById('admin-chat-widget-badge');

            if (!button || !panel || !listView || !chatView || !threadsContainer || !emptyState ||
                !closeList || !closeChat || !backButton || !messagesContainer || !form || !input || !title || !subtitle || !badge) {
                return;
            }

            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            const currentUserId = Number(widget.dataset.userId);
            const currentUserName = widget.dataset.userName || '';

            let threadsLoaded = false;
            let activeThreadId = null;
            let subscribed = false;
            let badgeCount = 0;
            const unreadByThread = {};

            const setWidgetState = (isOpen) => {
                widget.dataset.open = isOpen ? 'true' : 'false';
            };

            const setActiveThread = (threadId) => {
                activeThreadId = threadId ? Number(threadId) : null;
                widget.dataset.activeThreadId = activeThreadId ? String(activeThreadId) : '';
            };

            const showPanel = () => {
                panel.classList.remove('hidden');
                setWidgetState(true);
            };

            const hidePanel = () => {
                panel.classList.add('hidden');
                setWidgetState(false);
            };

            const showList = () => {
                listView.classList.remove('hidden');
                chatView.classList.add('hidden');
            };

            const showChat = () => {
                chatView.classList.remove('hidden');
                listView.classList.add('hidden');
                clearUnread(activeThreadId);
            };

            const updateBadge = (count) => {
                badgeCount = count;
                badge.textContent = String(badgeCount);

                if (badgeCount > 0) {
                    badge.classList.remove('hidden');
                } else {
                    badge.classList.add('hidden');
                }
            };

            const updateThreadBadge = (threadId) => {
                if (!threadId) {
                    return false;
                }
                const badgeEl = threadsContainer.querySelector(`[data-thread-badge="${threadId}"]`);
                if (!badgeEl) {
                    return false;
                }

                const count = unreadByThread[threadId] || 0;
                badgeEl.textContent = String(count);
                if (count > 0) {
                    badgeEl.classList.remove('hidden');
                } else {
                    badgeEl.classList.add('hidden');
                }
                return true;
            };

            const updateBadgeTotal = () => {
                const total = Object.values(unreadByThread).reduce((sum, value) => sum + value, 0);
                updateBadge(total);
            };

            const incrementUnread = (threadId) => {
                if (!threadId) {
                    return;
                }
                unreadByThread[threadId] = (unreadByThread[threadId] || 0) + 1;
                const badgeUpdated = updateThreadBadge(threadId);
                if (!badgeUpdated) {
                    threadsLoaded = false;
                }
                updateBadgeTotal();
            };

            const clearUnread = (threadId) => {
                if (!threadId) {
                    return;
                }
                unreadByThread[threadId] = 0;
                updateThreadBadge(threadId);
                updateBadgeTotal();
            };

            const showToast = ({ title: toastTitle, body }) => {
                const toast = document.createElement('div');
                toast.className = 'w-72 sm:w-80 rounded-xl bg-white shadow-lg ring-1 ring-black/10 p-4 flex gap-3';

                const content = document.createElement('div');
                content.className = 'flex-1';

                const heading = document.createElement('p');
                heading.className = 'text-sm font-semibold text-gray-800';
                heading.textContent = toastTitle;

                const message = document.createElement('p');
                message.className = 'mt-1 text-sm text-gray-600';
                message.textContent = body || 'Pesan baru masuk.';

                content.appendChild(heading);
                content.appendChild(message);

                const close = document.createElement('button');
                close.type = 'button';
                close.className = 'text-gray-400 hover:text-gray-600';
                close.textContent = 'x';
                close.addEventListener('click', () => toast.remove());

                toast.appendChild(content);
                toast.appendChild(close);
                toastContainer.appendChild(toast);

                setTimeout(() => {
                    toast.remove();
                }, 6000);
            };

            const requestJson = async (url, options = {}) => {
                const response = await fetch(url, {
                    credentials: 'same-origin',
                    ...options,
                    headers: {
                        Accept: 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        ...(options.headers || {}),
                    },
                });

                if (!response.ok) {
                    let message = 'Request gagal.';
                    try {
                        const error = await response.json();
                        if (error?.message) {
                            message = error.message;
                        }
                    } catch (err) {
                        message = response.statusText || message;
                    }
                    throw new Error(message);
                }

                if (response.status === 204) {
                    return null;
                }

                return response.json();
            };

            const renderThreads = (threads) => {
                threadsContainer.innerHTML = '';
                emptyState.classList.add('hidden');

                if (!threads.length) {
                    emptyState.classList.remove('hidden');
                    return;
                }

                threads.forEach((thread) => {
                    const button = document.createElement('button');
                    button.type = 'button';
                    button.className = 'w-full rounded-xl border border-gray-100 px-3 py-2 text-left transition hover:border-blue-200 hover:bg-blue-50';
                    button.dataset.threadId = thread.id;
                    const keluargaName = thread.keluarga_name || 'Keluarga';
                    const lansiaName = thread.lansia_name || '-';
                    const preview = thread.latest_message ? thread.latest_message.slice(0, 60) : 'Belum ada pesan';

                    button.innerHTML = `
                        <div class="flex items-center justify-between gap-3">
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-gray-800">${keluargaName}</p>
                                <p class="text-xs text-gray-500 truncate">${lansiaName}</p>
                                <p class="text-xs text-gray-400 truncate">${preview}</p>
                            </div>
                            <div class="flex flex-col items-end gap-2">
                                <span class="text-xs text-blue-600">Buka</span>
                                <span data-thread-badge="${thread.id}"
                                      class="hidden min-w-[1.25rem] rounded-full bg-red-500 px-1 text-center text-[10px] font-semibold leading-5 text-white">
                                    0
                                </span>
                            </div>
                        </div>
                    `;

                    button.addEventListener('click', () => selectThread(thread));
                    threadsContainer.appendChild(button);
                    updateThreadBadge(thread.id);
                });
            };

            const loadThreads = async () => {
                if (threadsLoaded) {
                    return;
                }

                threadsLoaded = true;
                threadsContainer.innerHTML = '<p class="text-sm text-gray-500 px-2">Memuat pesan...</p>';

                try {
                    const data = await requestJson('{{ route('admin.chat.index') }}');
                    renderThreads(data?.data || []);
                } catch (error) {
                    threadsContainer.innerHTML = `<p class="text-sm text-red-500 px-2">${error.message}</p>`;
                }
            };

            const applyThreadInfo = (thread) => {
                const keluargaName = thread.keluarga_name || 'Keluarga';
                const lansiaName = thread.lansia_name || '-';
                title.textContent = keluargaName;
                subtitle.textContent = `Lansia: ${lansiaName}`;
            };

            const appendMessage = (payload, isMineOverride = null) => {
                const empty = messagesContainer.querySelector('[data-empty]');
                if (empty) {
                    empty.remove();
                }

                const isMine = isMineOverride ?? (payload.sender_id === currentUserId);
                const wrapper = document.createElement('div');
                wrapper.className = `flex ${isMine ? 'justify-end' : 'justify-start'}`;

                const bubble = document.createElement('div');
                bubble.className = `max-w-[80%] rounded-2xl px-3 py-2 text-xs sm:text-sm ${
                    isMine ? 'bg-blue-600 text-white' : 'bg-white text-gray-800 shadow-sm'
                }`;

                const name = document.createElement('p');
                name.className = `text-[10px] ${isMine ? 'text-blue-100' : 'text-gray-400'}`;
                name.textContent = payload.sender_name || (isMine ? currentUserName : 'Keluarga');

                const body = document.createElement('p');
                body.textContent = payload.body;

                const time = document.createElement('p');
                time.className = `mt-1 text-[10px] ${isMine ? 'text-blue-100' : 'text-gray-400'}`;
                time.textContent = payload.created_at
                    ? new Date(payload.created_at).toLocaleString('id-ID')
                    : '';

                bubble.appendChild(name);
                bubble.appendChild(body);
                bubble.appendChild(time);
                wrapper.appendChild(bubble);
                messagesContainer.appendChild(wrapper);
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            };

            const loadMessages = async (threadId) => {
                messagesContainer.innerHTML = '<p class="text-sm text-gray-500">Memuat pesan...</p>';

                try {
                    const data = await requestJson(`/admin/chat/${threadId}`);
                    setActiveThread(data?.thread?.id);
                    applyThreadInfo(data?.thread || {});

                    messagesContainer.innerHTML = '';
                    const messages = data?.messages || [];
                    if (!messages.length) {
                        messagesContainer.innerHTML = '<p data-empty="true" class="text-sm text-gray-500">Belum ada pesan.</p>';
                    } else {
                        messages.forEach((message) => appendMessage(message));
                    }

                    clearUnread(threadId);
                } catch (error) {
                    messagesContainer.innerHTML = `<p class="text-sm text-red-500">${error.message}</p>`;
                }
            };

            const selectThread = async (thread) => {
                setActiveThread(thread.id);
                applyThreadInfo(thread);
                showChat();
                await loadMessages(thread.id);
            };

            const handleIncoming = (event) => {
                if (event.sender_id === currentUserId) {
                    return;
                }

                if (activeThreadId && Number(event.thread_id) === activeThreadId && widget.dataset.open === 'true') {
                    appendMessage(event);
                    return;
                }

                incrementUnread(Number(event.thread_id));
                showToast({
                    title: `Pesan baru dari ${event.sender_name || 'Keluarga'}`,
                    body: event.body || 'Pesan baru masuk.',
                });
            };

            const subscribe = () => {
                if (subscribed || !window.Echo) {
                    return subscribed;
                }

                window.Echo.private('chat.admin')
                    .listen('MessageSent', handleIncoming);

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

            button.addEventListener('click', () => {
                if (panel.classList.contains('hidden')) {
                    showPanel();
                    if (activeThreadId) {
                        showChat();
                        loadMessages(activeThreadId);
                    } else {
                        showList();
                        loadThreads();
                    }
                } else {
                    hidePanel();
                }
            });

            closeList.addEventListener('click', hidePanel);
            closeChat.addEventListener('click', hidePanel);
            backButton.addEventListener('click', () => {
                showList();
                loadThreads();
            });

            form.addEventListener('submit', async (event) => {
                event.preventDefault();
                const body = input.value.trim();
                if (!body || !activeThreadId) {
                    return;
                }

                const payload = {
                    body,
                    sender_id: currentUserId,
                    sender_name: currentUserName,
                    created_at: new Date().toISOString(),
                };
                appendMessage(payload, true);
                input.value = '';

                try {
                    await requestJson(`/admin/chat/${activeThreadId}`, {
                        method: 'POST',
                        body: JSON.stringify({ body }),
                    });
                } catch (error) {
                    messagesContainer.insertAdjacentHTML('beforeend', `<p class="text-xs text-red-500">${error.message}</p>`);
                }
            });
        })();
    </script>
</body>

</html>
