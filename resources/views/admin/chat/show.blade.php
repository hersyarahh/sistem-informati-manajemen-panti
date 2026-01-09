@extends('layouts.app-admin')

@section('title', 'Pesan Keluarga')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Percakapan Keluarga</h1>
            <p class="text-sm text-gray-500">
                {{ $thread->keluarga?->name ?? '-' }} - {{ $thread->lansia?->nama_lengkap ?? '-' }}
            </p>
        </div>
        <a href="{{ route('admin.chat.index') }}"
           class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 text-sm">
            Kembali
        </a>
    </div>

    <div class="bg-white rounded-xl shadow p-4 sm:p-6">
        <div id="chat-messages"
             class="space-y-3 max-h-[60vh] overflow-auto pr-1"
             data-thread-id="{{ $thread->id }}"
             data-user-id="{{ auth()->id() }}"
             data-user-name="{{ auth()->user()->name }}">
            @forelse ($messages as $message)
                @php $isMine = $message->sender_id === auth()->id(); @endphp
                <div class="flex {{ $isMine ? 'justify-end' : 'justify-start' }}">
                    <div class="max-w-[80%] sm:max-w-[70%] rounded-lg px-4 py-2 text-sm
                        {{ $isMine ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-800' }}">
                        <p class="text-xs {{ $isMine ? 'text-blue-100' : 'text-gray-500' }}">
                            {{ $message->sender?->name ?? 'Petugas' }}
                        </p>
                        <p>{{ $message->body }}</p>
                        <p class="mt-1 text-[10px] {{ $isMine ? 'text-blue-100' : 'text-gray-400' }}">
                            {{ $message->created_at?->format('d/m/Y H:i') }}
                        </p>
                    </div>
                </div>
            @empty
                <div class="text-sm text-gray-500 text-center py-6">
                    Belum ada pesan.
                </div>
            @endforelse
        </div>

        <form id="chat-form"
              action="{{ route('admin.chat.store', $thread) }}"
              method="POST"
              class="mt-4 flex flex-col sm:flex-row gap-2">
            @csrf
            <input type="text" name="body" id="chat-body"
                   class="flex-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-200"
                   placeholder="Tulis pesan..." required>
            <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Kirim
            </button>
        </form>
    </div>
</div>

<script>
    (function () {
        const container = document.getElementById('chat-messages');
        const form = document.getElementById('chat-form');
        const input = document.getElementById('chat-body');

        if (!container || !form || !input) {
            return;
        }

        const threadId = container.dataset.threadId;
        const currentUserId = Number(container.dataset.userId);
        const currentUserName = container.dataset.userName;

        const appendMessage = (payload, isMineOverride = null) => {
            const isMine = isMineOverride ?? (payload.sender_id === currentUserId);
            const wrapper = document.createElement('div');
            wrapper.className = `flex ${isMine ? 'justify-end' : 'justify-start'}`;

            const bubble = document.createElement('div');
            bubble.className = `max-w-[80%] sm:max-w-[70%] rounded-lg px-4 py-2 text-sm ${
                isMine ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-800'
            }`;

            const meta = document.createElement('p');
            meta.className = `text-xs ${isMine ? 'text-blue-100' : 'text-gray-500'}`;
            meta.textContent = payload.sender_name || 'Petugas';

            const body = document.createElement('p');
            body.textContent = payload.body;

            const time = document.createElement('p');
            time.className = `mt-1 text-[10px] ${isMine ? 'text-blue-100' : 'text-gray-400'}`;
            time.textContent = new Date(payload.created_at).toLocaleString('id-ID');

            bubble.appendChild(meta);
            bubble.appendChild(body);
            bubble.appendChild(time);
            wrapper.appendChild(bubble);
            container.appendChild(wrapper);
            container.scrollTop = container.scrollHeight;
        };

        let subscribed = false;
        const subscribe = () => {
            if (subscribed || !window.Echo) {
                return subscribed;
            }

            window.Echo.private(`chat.thread.${threadId}`)
                .listen('MessageSent', (event) => {
                    appendMessage(event);
                });

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

        form.addEventListener('submit', async (event) => {
            event.preventDefault();
            const body = input.value.trim();
            if (!body) {
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
                await window.axios.post(form.action, { body });
            } catch (error) {
                window.location.reload();
            }
        });
    })();
</script>
@endsection
