<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Moderator extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'first_name', 'last_name', 'phone'
    ];

    public function rules()
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required|unique:users',
        ];
    }

    public function updateRules()
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
