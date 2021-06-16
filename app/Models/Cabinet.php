<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cabinet extends Model
{
    protected $table = 'cabinets';

    protected $fillable = ['title', 'floor'];

    public function rules()
    {
        return [
            'title' => 'required|max:32',
        ];
    }
}
