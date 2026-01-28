<?php

namespace App\Http\Controllers\Keluarga;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Models\ChatMessage;
use App\Models\ChatThread;
use App\Models\KeluargaLansia;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        $keluargaLansia = KeluargaLansia::where('user_id', auth()->id())
            ->with('lansia')
            ->first();

        if (!$keluargaLansia) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Anda belum terdaftar sebagai keluarga dari lansia manapun. Silakan hubungi admin.',
                ], Response::HTTP_FORBIDDEN);
            }

            return redirect()
                ->route('keluarga.dashboard')
                ->with('message', 'Gunakan widget chat di pojok kanan bawah untuk menghubungi admin.');
        }

        $thread = ChatThread::firstOrCreate([
            'lansia_id' => $keluargaLansia->lansia_id,
            'keluarga_user_id' => auth()->id(),
        ]);

        $messages = ChatMessage::where('thread_id', $thread->id)
            ->with('sender')
            ->orderBy('created_at')
            ->get();

        if (!$request->expectsJson()) {
            return redirect()
                ->route('keluarga.dashboard')
                ->with('message', 'Gunakan widget chat di pojok kanan bawah untuk menghubungi admin.');
        }

        return response()->json([
            'thread' => [
                'id' => $thread->id,
                'assigned_admin_id' => $thread->assigned_admin_id,
            ],
            'lansia' => [
                'id' => $keluargaLansia->lansia->id,
                'nama_lengkap' => $keluargaLansia->lansia->nama_lengkap,
            ],
            'assigned_admin' => $thread->assignedAdmin
                ? [
                    'id' => $thread->assignedAdmin->id,
                    'name' => $thread->assignedAdmin->name,
                    'role' => $thread->assignedAdmin->role?->name,
                ]
                : null,
            'messages' => $messages->map(function (ChatMessage $message) {
                return [
                    'id' => $message->id,
                    'thread_id' => $message->thread_id,
                    'body' => $message->body,
                    'sender_id' => $message->sender_id,
                    'sender_name' => $message->sender?->name,
                    'created_at' => $message->created_at?->toIso8601String(),
                ];
            }),
        ]);
    }

    public function contacts()
    {
        $contacts = User::with('role')
            ->whereHas('role', function ($query) {
                $query->whereIn('name', ['admin', 'karyawan']);
            })
            ->orderBy('name')
            ->get(['id', 'name', 'role_id']);

        return response()->json([
            'data' => $contacts->map(function (User $user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'role' => $user->role?->name,
                ];
            }),
        ]);
    }

    public function assignAdmin(Request $request)
    {
        $data = $request->validate([
            'admin_id' => ['required', 'integer', 'exists:users,id'],
        ]);

        $admin = User::with('role')
            ->whereHas('role', function ($query) {
                $query->whereIn('name', ['admin', 'karyawan']);
            })
            ->where('id', $data['admin_id'])
            ->firstOrFail();

        $keluargaLansia = KeluargaLansia::where('user_id', auth()->id())
            ->first();

        if (!$keluargaLansia) {
            return response()->json([
                'message' => 'Anda belum terdaftar sebagai keluarga dari lansia manapun. Silakan hubungi admin.',
            ], Response::HTTP_FORBIDDEN);
        }

        $thread = ChatThread::firstOrCreate([
            'lansia_id' => $keluargaLansia->lansia_id,
            'keluarga_user_id' => auth()->id(),
        ]);

        $thread->assigned_admin_id = $admin->id;
        $thread->save();

        return response()->json([
            'thread_id' => $thread->id,
            'assigned_admin' => [
                'id' => $admin->id,
                'name' => $admin->name,
                'role' => $admin->role?->name,
            ],
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
