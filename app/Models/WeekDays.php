<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class WeekDays extends Model
{
    protected $table = 'week_days';

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'week_day_id', 'id');
    }


}
