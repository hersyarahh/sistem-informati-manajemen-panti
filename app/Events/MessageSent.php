<?php

namespace App\Events;

use App\Models\ChatMessage;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public ChatMessage $message;

    public function __construct(ChatMessage $message)
    {
        $this->message = $message->load(['sender', 'thread']);
    }

    public function broadcastOn(): array
    {
        $channels = [
            new PrivateChannel('chat.thread.' . $this->message->thread_id),
            new PrivateChannel('chat.admin'),
        ];

        if ($this->message->thread?->keluarga_user_id) {
            $channels[] = new PrivateChannel('chat.user.' . $this->message->thread->keluarga_user_id);
        }

        return $channels;
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->message->id,
            'thread_id' => $this->message->thread_id,
            'body' => $this->message->body,
            'sender_id' => $this->message->sender_id,
            'sender_name' => $this->message->sender?->name,
            'created_at' => $this->message->created_at?->toIso8601String(),
        ];
    }
}
