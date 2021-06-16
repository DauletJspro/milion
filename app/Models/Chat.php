<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chat extends Model
{
    use SoftDeletes;

    protected $table = 'chats';
    protected $fillable = [
        'name',
        'type'
    ];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
