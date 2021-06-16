<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{

    protected $table = 'news';

    use SoftDeletes;

    protected $fillable = [
        'name',
        'title',
        'is_important',
        'is_active',
        'author_id',
        'content',
        'image',
    ];

    public static function rules()
    {
        return [
            'name' => 'required',
            'title' => 'required',
            'image' => 'required|file|mimes:jpeg,bmp,png|max:500000',
            'news_content' => 'required',
        ];
    }

    public static function updateRules()
    {
        return [
            'name' => 'required',
            'title' => 'required',
            'news_content' => 'required',
        ];
    }

}
