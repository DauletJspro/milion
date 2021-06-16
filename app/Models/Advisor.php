<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;

class Advisor extends Model
{
    use SoftDeletes;

    protected $table = 'advisors';

    protected $fillable = ['first_name', 'last_name', 'middle_name', 'social_id', 'phone', 'address'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function rules()
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'middle_name' => 'required',
            'social_id' => 'required',
            'phone' => ['required', 'unique:users'],
            'address' => 'required',
        ];
    }

    public function updateRules()
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'middle_name' => 'required',
            'social_id' => 'required',
            'address' => 'required',
        ];
    }
}
