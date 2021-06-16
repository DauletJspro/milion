<?php

namespace App\Models;

use Facade\FlareClient\Truncation\ReportTrimmer;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles, HasApiTokens, SoftDeletes;

    const ROLE_ADMIN = 1;
    const ROLE_MODERATOR = 2;
    const ROLE_TEACHER = 3;
    const ROLE_ADVISOR = 4;
    const ROLE_STUDENT = 5;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'debt'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public static function getRoleName($role_id)
    {
        switch ($role_id) {
            case self::ROLE_ADMIN:
                return 'Администратор';
            case self::ROLE_MODERATOR:
                return 'Модератор';
            case self::ROLE_TEACHER:
                return 'Учитель';
            case self::ROLE_ADVISOR:
                return 'Куратор';
            case self::ROLE_STUDENT:
                return 'Студент';
        }
    }

    public function student()
    {
        return $this->hasOne(Student::class, 'user_id', 'id');
    }

    public function teacher()
    {
        return $this->hasOne(Teacher::class, 'user_id', 'id');
    }

    public function advisor()
    {
        return $this->hasOne(Advisor::class, 'user_id', 'id');
    }

    public function moderator()
    {
        return $this->hasOne(Moderator::class, 'user_id', 'id');
    }

}
