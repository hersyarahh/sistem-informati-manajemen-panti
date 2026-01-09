<?php

namespace App\Http\Controllers\Admin;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Models\ChatMessage;
use App\Models\ChatThread;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        $threads = ChatThread::with(['lansia', 'keluarga', 'latestMessage.sender'])
            ->orderByDesc('updated_at')
            ->get();

        return view('admin.chat.index', compact('threads'));
    }

    public function show(ChatThread $thread)
    {
        $thread->load(['lansia', 'keluarga']);

        $messages = ChatMessage::where('thread_id', $thread->id)
            ->with('sender')
            ->orderBy('created_at')
            ->get();

        return view('admin.chat.show', [
            'thread' => $thread,
            'messages' => $messages,
        ]);
    }

    public function store(Request $request, ChatThread $thread)
    {
        $data = $request->validate([
            'body' => ['required', 'string', 'max:2000'],
        ]);

        $message = ChatMessage::create([
            'thread_id' => $thread->id,
            'sender_id' => auth()->id(),
            'body' => $data['body'],
        ]);

        $thread->touch();

        broadcast(new MessageSent($message))->toOthers();

        if ($request->expectsJson()) {
            return response()->json([
                'id' => $message->id,
                'thread_id' => $message->thread_id,
                'body' => $message->body,
                'sender_id' => $message->sender_id,
                'sender_name' => $message->sender?->name,
                'created_at' => $message->created_at?->toIso8601String(),
            ]);
        }

        return redirect()->route('admin.chat.show', $thread);
    }
}
