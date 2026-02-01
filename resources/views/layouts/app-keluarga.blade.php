<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'PSTW Husnul Khotimah') }} - @yield('title')</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="m-0 p-0 bg-gray-100 font-sans">
    <div class="relative min-h-screen w-screen">
        <!-- MOBILE OVERLAY -->
        <div id="keluarga-sidebar-overlay"
            class="fixed inset-0 z-30 bg-black/40 opacity-0 pointer-events-none transition-opacity duration-200 lg:hidden">
        </div>

        <!-- SIDEBAR -->
        <aside id="keluarga-sidebar"
            class="fixed inset-y-0 left-0 z-40 w-64 -translate-x-full bg-blue-700 text-white flex flex-col min-h-screen transform transition-transform duration-200 ease-out lg:translate-x-0">

            <div class="px-5 py-6">
                <h2 class="text-xl font-bold mb-1">Menu Keluarga</h2>
                <p class="text-xs text-blue-100">Portal Keluarga</p>
            </div>

            <nav class="flex flex-col space-y-3 px-5 flex-1">
                @php
                    $navBase = 'flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition';
                    $navActive = 'bg-blue-800 text-white shadow';
                    $navInactive = 'text-blue-100 hover:bg-blue-600 hover:text-white';
                @endphp

                @php $isActive = request()->routeIs('keluarga.dashboard'); @endphp
                <a href="{{ route('keluarga.dashboard') }}"
                   class="{{ $navBase }} {{ $isActive ? $navActive : $navInactive }}"
                   @if ($isActive) aria-current="page" @endif>
                    Beranda
                </a>

                @php $isActive = request()->routeIs('keluarga.profile'); @endphp
                <a href="{{ route('keluarga.profile') }}"
                   class="{{ $navBase }} {{ $isActive ? $navActive : $navInactive }}"
                   @if ($isActive) aria-current="page" @endif>
                    Profil Lansia
                </a>

                @php $isActive = request()->routeIs('keluarga.kegiatan'); @endphp
                <a href="{{ route('keluarga.kegiatan') }}"
                   class="{{ $navBase }} {{ $isActive ? $navActive : $navInactive }}"
                   @if ($isActive) aria-current="page" @endif>
                    Jadwal Kegiatan
                </a>

            </nav>

            <div class="px-5 pb-4">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full bg-red-500 hover:bg-red-600 text-white p-3 rounded-xl text-center text-sm">
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="min-h-screen overflow-auto px-4 py-6 sm:px-8 sm:py-8 flex items-start justify-center lg:pl-64">
            <div class="w-full max-w-6xl flex flex-col gap-6">
                <div class="fixed left-4 top-4 z-50 flex items-center gap-3 lg:static lg:z-auto lg:hidden">
                    <button id="keluarga-sidebar-toggle" type="button"
                        class="inline-flex items-center justify-center rounded-lg bg-white p-2 text-gray-700 shadow hover:bg-gray-50"
                        aria-controls="keluarga-sidebar" aria-expanded="false">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <span class="text-sm font-semibold text-gray-600">Menu Keluarga</span>
                </div>

                @yield('content')
            </div>
        </main>
    </div>

    <script>
        (function () {
            const toggle = document.getElementById('keluarga-sidebar-toggle');
            const sidebar = document.getElementById('keluarga-sidebar');
            const overlay = document.getElementById('keluarga-sidebar-overlay');

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

    <div id="chat-widget"
         data-user-id="{{ auth()->id() }}"
         data-user-name="{{ auth()->user()->name }}"
         data-open="false"
         data-active-thread-id=""
         class="fixed bottom-5 right-5 z-40 flex flex-col items-end gap-3">
        <div id="chat-widget-panel"
             class="hidden w-[20rem] sm:w-96 overflow-hidden rounded-2xl bg-white shadow-2xl ring-1 ring-black/10">
            <div id="chat-widget-list" class="flex flex-col">
                <div class="flex items-center justify-between border-b border-gray-100 px-4 py-3">
                    <div>
                        <p class="text-sm font-semibold text-gray-800">Hubungi Admin</p>
                        <p class="text-xs text-gray-500">Pilih admin yang ingin dihubungi</p>
                    </div>
                    <button id="chat-widget-close" type="button" class="text-gray-400 hover:text-gray-600">
                        <span class="sr-only">Tutup</span>
                        x
                    </button>
                </div>
                <div id="chat-widget-contacts" class="max-h-64 overflow-auto p-3 space-y-2"></div>
                <div id="chat-widget-contacts-empty" class="hidden px-4 py-6 text-center text-sm text-gray-500">
                    Tidak ada admin yang tersedia.
                </div>
            </div>

            <div id="chat-widget-chat" class="hidden flex flex-col">
                <div class="flex items-center justify-between bg-blue-600 px-4 py-3 text-white">
                    <div>
                        <p id="chat-widget-title" class="text-sm font-semibold">Admin</p>
                        <p id="chat-widget-subtitle" class="text-xs text-blue-100">Siap membantu</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <button id="chat-widget-back" type="button" class="text-blue-100 hover:text-white">
                            <span class="sr-only">Kembali</span>
                            &lt;
                        </button>
                        <button id="chat-widget-close-chat" type="button" class="text-blue-100 hover:text-white">
                            <span class="sr-only">Tutup</span>
                            x
                        </button>
                    </div>
                </div>
                <div id="chat-widget-messages"
                     class="max-h-64 overflow-auto bg-gray-50 p-3 space-y-3 text-sm">
                </div>
                <form id="chat-widget-form" class="flex items-center gap-2 border-t border-gray-100 bg-white p-3">
                    <input id="chat-widget-input" type="text"
                           class="flex-1 rounded-full border border-gray-200 px-4 py-2 text-sm focus:border-blue-400 focus:outline-none focus:ring focus:ring-blue-100"
                           placeholder="Tulis pesan..." autocomplete="off" />
                    <button type="submit"
                            class="rounded-full bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
                        Kirim
                    </button>
                </form>
            </div>
        </div>

        <button id="chat-widget-button" type="button"
                class="relative flex h-14 w-14 items-center justify-center rounded-full bg-blue-600 text-white shadow-lg transition hover:bg-blue-700"
                aria-label="Buka chat">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M8 10h8m-8 4h5m9-2a9 9 0 11-3.6-7.2L21 4l-1.8 4.6A8.96 8.96 0 0121 12z"/>
            </svg>
            <span id="chat-widget-badge"
                  class="absolute -right-1 -top-1 hidden min-w-[1.25rem] rounded-full bg-red-500 px-1 text-center text-[10px] font-semibold leading-5 text-white">
                0
            </span>
        </button>
    </div>

    <script>
        (function () {
            const widget = document.getElementById('chat-widget');
            if (!widget) {
                return;
            }

            const button = document.getElementById('chat-widget-button');
            const panel = document.getElementById('chat-widget-panel');
            const listView = document.getElementById('chat-widget-list');
            const chatView = document.getElementById('chat-widget-chat');
            const contactsContainer = document.getElementById('chat-widget-contacts');
            const contactsEmpty = document.getElementById('chat-widget-contacts-empty');
            const closeList = document.getElementById('chat-widget-close');
            const closeChat = document.getElementById('chat-widget-close-chat');
            const backButton = document.getElementById('chat-widget-back');
            const messagesContainer = document.getElementById('chat-widget-messages');
            const form = document.getElementById('chat-widget-form');
            const input = document.getElementById('chat-widget-input');
            const title = document.getElementById('chat-widget-title');
            const subtitle = document.getElementById('chat-widget-subtitle');
            const badge = document.getElementById('chat-widget-badge');

            if (!button || !panel || !listView || !chatView || !contactsContainer || !contactsEmpty ||
                !closeList || !closeChat || !backButton || !messagesContainer || !form || !input || !title || !subtitle || !badge) {
                return;
            }

            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            const currentUserId = Number(widget.dataset.userId);
            const currentUserName = widget.dataset.userName || '';

            let contactsLoaded = false;
            let activeThreadId = null;
            let activeAdmin = null;
            let subscribedThreadId = null;
            let badgeCount = 0;
            const unreadByAdmin = {};

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
                resetBadge();
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

            const incrementBadge = () => updateBadge(badgeCount + 1);
            const resetBadge = () => updateBadge(0);

            window.chatWidgetBadge = {
                increment: incrementBadge,
                reset: resetBadge,
            };

            const updateContactBadge = (adminId) => {
                const badgeEl = contactsContainer.querySelector(`[data-contact-badge="${adminId}"]`);
                if (!badgeEl) {
                    return;
                }

                const count = unreadByAdmin[adminId] || 0;
                badgeEl.textContent = String(count);
                if (count > 0) {
                    badgeEl.classList.remove('hidden');
                } else {
                    badgeEl.classList.add('hidden');
                }
            };

            const updateBadgeTotal = () => {
                const total = Object.values(unreadByAdmin).reduce((sum, value) => sum + value, 0);
                updateBadge(total);
            };

            const incrementUnread = (adminId) => {
                if (!adminId) {
                    incrementBadge();
                    return;
                }

                unreadByAdmin[adminId] = (unreadByAdmin[adminId] || 0) + 1;
                updateContactBadge(adminId);
                updateBadgeTotal();
            };

            const clearUnread = (adminId) => {
                if (!adminId) {
                    resetBadge();
                    return;
                }

                unreadByAdmin[adminId] = 0;
                updateContactBadge(adminId);
                updateBadgeTotal();
            };

            window.chatWidgetNotifications = {
                incrementUnread,
                clearUnread,
                updateTotal: updateBadgeTotal,
                resetTotal: resetBadge,
            };

            const requestJson = async (url, options = {}) => {
                const socketId = window.Echo?.socketId?.();
                const response = await fetch(url, {
                    credentials: 'same-origin',
                    ...options,
                    headers: {
                        Accept: 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        ...(socketId ? { 'X-Socket-ID': socketId } : {}),
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

            const renderContacts = (contacts) => {
                contactsContainer.innerHTML = '';
                contactsEmpty.classList.add('hidden');

                if (!contacts.length) {
                    contactsEmpty.classList.remove('hidden');
                    return;
                }

                contacts.forEach((contact) => {
                    const button = document.createElement('button');
                    button.type = 'button';
                    button.className = 'w-full rounded-xl border border-gray-100 px-3 py-2 text-left transition hover:border-blue-200 hover:bg-blue-50';
                    button.dataset.contactId = contact.id;
                    button.innerHTML = `
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-semibold text-gray-800">${contact.name}</p>
                                <p class="text-xs text-gray-500">${contact.role || 'Admin'}</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-xs text-blue-600">Pilih</span>
                                <span data-contact-badge="${contact.id}"
                                      class="hidden min-w-[1.25rem] rounded-full bg-red-500 px-1 text-center text-[10px] font-semibold leading-5 text-white">
                                    0
                                </span>
                            </div>
                        </div>
                    `;
                    button.addEventListener('click', () => selectAdmin(contact));
                    contactsContainer.appendChild(button);
                    updateContactBadge(contact.id);
                });
            };

            const loadContacts = async () => {
                if (contactsLoaded) {
                    return;
                }

                contactsLoaded = true;
                contactsContainer.innerHTML = '<p class="text-sm text-gray-500 px-2">Memuat daftar admin...</p>';

                try {
                    const data = await requestJson('{{ route('keluarga.chat.contacts') }}');
                    renderContacts(data?.data || []);
                } catch (error) {
                    contactsContainer.innerHTML = `<p class="text-sm text-red-500 px-2">${error.message}</p>`;
                }
            };

            const applyAdmin = (admin) => {
                activeAdmin = admin;
                title.textContent = admin?.name || 'Admin';
                subtitle.textContent = admin?.role ? `Petugas ${admin.role}` : 'Siap membantu';
                if (admin?.id) {
                    clearUnread(admin.id);
                }
            };

            const appendMessage = (payload, isMineOverride = null) => {
                const emptyState = messagesContainer.querySelector('[data-empty]');
                if (emptyState) {
                    emptyState.remove();
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
                name.textContent = payload.sender_name || (isMine ? currentUserName : 'Admin');

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

            const loadMessages = async () => {
                messagesContainer.innerHTML = '<p class="text-sm text-gray-500">Memuat pesan...</p>';

                try {
                    const data = await requestJson('{{ route('keluarga.chat') }}');
                    setActiveThread(data?.thread?.id);
                    if (data?.assigned_admin) {
                        applyAdmin(data.assigned_admin);
                    }

                    messagesContainer.innerHTML = '';
                    const messages = data?.messages || [];
                    if (!messages.length) {
                    messagesContainer.innerHTML = '<p data-empty="true" class="text-sm text-gray-500">Belum ada pesan.</p>';
                    } else {
                        messages.forEach((message) => appendMessage(message));
                    }

                    subscribeToThread();
                    resetBadge();
                } catch (error) {
                    messagesContainer.innerHTML = `<p class="text-sm text-red-500">${error.message}</p>`;
                }
            };

            const selectAdmin = async (admin) => {
                applyAdmin(admin);
                showChat();

                try {
                    const data = await requestJson('{{ route('keluarga.chat.assign') }}', {
                        method: 'POST',
                        body: JSON.stringify({ admin_id: admin.id }),
                    });
                    setActiveThread(data?.thread_id);
                    await loadMessages();
                } catch (error) {
                    messagesContainer.innerHTML = `<p class="text-sm text-red-500">${error.message}</p>`;
                }
            };

            const subscribeToThread = () => {
                if (!activeThreadId) {
                    return;
                }

                const trySubscribe = () => {
                    if (!window.Echo || subscribedThreadId === activeThreadId) {
                        return !!window.Echo;
                    }

                    window.Echo.private(`chat.thread.${activeThreadId}`)
                        .listen('MessageSent', (event) => {
                            appendMessage(event);
                        });

                    subscribedThreadId = activeThreadId;
                    return true;
                };

                if (!trySubscribe()) {
                    const interval = setInterval(() => {
                        if (trySubscribe()) {
                            clearInterval(interval);
                        }
                    }, 200);
                }
            };

            button.addEventListener('click', () => {
                if (panel.classList.contains('hidden')) {
                    showPanel();
                    if (activeAdmin) {
                        showChat();
                        loadMessages();
                    } else {
                        showList();
                        loadContacts();
                    }
                } else {
                    hidePanel();
                }
            });

            closeList.addEventListener('click', hidePanel);
            closeChat.addEventListener('click', hidePanel);
            backButton.addEventListener('click', () => {
                showList();
                loadContacts();
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
                    await requestJson(`/keluarga/pesan/${activeThreadId}`, {
                        method: 'POST',
                        body: JSON.stringify({ body }),
                    });
                } catch (error) {
                    messagesContainer.insertAdjacentHTML('beforeend', `<p class="text-xs text-red-500">${error.message}</p>`);
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
            const widget = document.getElementById('chat-widget');
            const getWidgetThreadId = () => {
                if (!widget) {
                    return null;
                }
                const value = widget.dataset.activeThreadId;
                return value ? Number(value) : null;
            };
            const isWidgetOpen = () => widget?.dataset.open === 'true';

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
                message.textContent = body || 'Pesan baru masuk.';

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

                if (isWidgetOpen() && getWidgetThreadId() === Number(event.thread_id)) {
                    return;
                }

                window.chatWidgetNotifications?.incrementUnread?.(Number(event.sender_id));

                showToast({
                    title: `Pesan baru dari ${event.sender_name || 'Petugas'}`,
                    body: 'Silakan buka widget chat untuk melihat pesan.',
                });
            };

            let subscribed = false;
            const subscribe = () => {
                if (subscribed || !window.Echo) {
                    return subscribed;
                }

                window.Echo.private(`chat.user.${currentUserId}`)
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
