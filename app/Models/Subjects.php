<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subjects extends Model
{
    use SoftDeletes;

    protected $table = 'subjects';
    protected $fillable = [
        'title'
    ];

    public function group()
    {
        return $this->hasOne(Group::class, 'subject_id', 'id');
    }
}
