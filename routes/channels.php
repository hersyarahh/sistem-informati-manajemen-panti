<?php

use App\Models\ChatThread;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('chat.thread.{threadId}', function ($user, $threadId) {
    $thread = ChatThread::find($threadId);

    if (!$thread) {
        return false;
    }

    if ($user->hasAnyRole(['admin', 'karyawan'])) {
        return true;
    }

    return (int) $thread->keluarga_user_id === (int) $user->id;
});

Broadcast::channel('chat.admin', function ($user) {
    return $user->hasAnyRole(['admin', 'karyawan']);
});

Broadcast::channel('chat.user.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});
