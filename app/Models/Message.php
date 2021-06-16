<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use SoftDeletes;

    protected $table = 'messages';
    protected $fillable = [
        'sender_id',
        'recipient_id',
        'message',
        'chat_id',
    ];

    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }
}
