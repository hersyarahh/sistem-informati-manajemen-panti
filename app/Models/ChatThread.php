<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatThread extends Model
{
    use HasFactory;

    protected $fillable = [
        'lansia_id',
        'keluarga_user_id',
    ];

    public function lansia()
    {
        return $this->belongsTo(Lansia::class);
    }

    public function keluarga()
    {
        return $this->belongsTo(User::class, 'keluarga_user_id');
    }

    public function messages()
    {
        return $this->hasMany(ChatMessage::class, 'thread_id');
    }

    public function latestMessage()
    {
        return $this->hasOne(ChatMessage::class, 'thread_id')->latestOfMany();
    }
}
