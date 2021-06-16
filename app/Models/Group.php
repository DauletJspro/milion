<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use SoftDeletes;

    protected $table = 'groups';

    protected $fillable = [
        'name',
        'subject_id',
        'is_active',
        'teacher_id',
    ];


    public function subject()
    {
        return $this->hasOne(Subjects::class, 'id', 'subject_id');
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, GroupStudent::class);
    }

    public function groupStudents()
    {
        return $this->hasMany(GroupStudent::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
