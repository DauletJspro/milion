<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Teacher extends Model
{
    use SoftDeletes;

    protected $table = 'teachers';
    protected $primaryKey = 'id';
    protected $fillable = ['first_name', 'last_name', 'middle_name', 'social_id', 'phone'];


    public function rules()
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'middle_name' => 'required',
            'social_id' => 'required',
            'phone' => 'required|unique:users',
        ];
    }

    public function updateRules()
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'middle_name' => 'required',
            'social_id' => 'required',
            'phone' => 'required',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function groups()
    {
        return $this->hasMany(Group::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subjects::class, Group::class, 'teacher_id', 'subject_id');
    }
}
