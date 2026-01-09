import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

const broadcastDriver = import.meta.env.VITE_BROADCAST_DRIVER;

if (broadcastDriver === 'reverb' || broadcastDriver === 'pusher') {
    window.Pusher = Pusher;

    const authToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    window.Echo = new Echo({
        broadcaster: broadcastDriver,
        key: broadcastDriver === 'reverb'
            ? import.meta.env.VITE_REVERB_APP_KEY
            : import.meta.env.VITE_PUSHER_APP_KEY,
        wsHost: broadcastDriver === 'reverb' ? import.meta.env.VITE_REVERB_HOST : undefined,
        wsPort: broadcastDriver === 'reverb' ? import.meta.env.VITE_REVERB_PORT ?? 80 : undefined,
        wssPort: broadcastDriver === 'reverb' ? import.meta.env.VITE_REVERB_PORT ?? 443 : undefined,
        forceTLS: broadcastDriver === 'reverb'
            ? (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https'
            : true,
        enabledTransports: ['ws', 'wss'],
        cluster: broadcastDriver === 'pusher' ? import.meta.env.VITE_PUSHER_APP_CLUSTER : undefined,
        authEndpoint: '/broadcasting/auth',
        auth: {
            headers: {
                'X-CSRF-TOKEN': authToken,
            },
        },
    });
}
