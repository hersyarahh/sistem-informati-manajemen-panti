<?php

namespace App\Http\Controllers\Keluarga;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Models\ChatMessage;
use App\Models\ChatThread;
use App\Models\KeluargaLansia;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ChatController extends Controller
{
    public function index()
    {
        $keluargaLansia = KeluargaLansia::where('user_id', auth()->id())
            ->with('lansia')
            ->first();

        if (!$keluargaLansia) {
            return redirect()
                ->route('keluarga.dashboard')
                ->with('message', 'Anda belum terdaftar sebagai keluarga dari lansia manapun. Silakan hubungi admin.');
        }

        $thread = ChatThread::firstOrCreate([
            'lansia_id' => $keluargaLansia->lansia_id,
            'keluarga_user_id' => auth()->id(),
        ]);

        $messages = ChatMessage::where('thread_id', $thread->id)
            ->with('sender')
            ->orderBy('created_at')
            ->get();

        return view('keluarga.chat', [
            'lansia' => $keluargaLansia->lansia,
            'thread' => $thread,
            'messages' => $messages,
        ]);
    }

    public function store(Request $request, ChatThread $thread)
    {
        if ($thread->keluarga_user_id !== auth()->id()) {
            abort(Response::HTTP_FORBIDDEN);
        }

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

        return redirect()->route('keluarga.chat');
    }
}
