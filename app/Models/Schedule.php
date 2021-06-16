<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Schedule extends Model
{
    protected $table = 'schedules';

    public static function rules()
    {
        return [
            'cabinet_id' => 'required',
            'week_day_id' => 'required',
            'lesson_time' => 'required',
            'group_id' => 'required',
        ];
    }


    public function cabinet()
    {
        return $this->hasOne(Cabinet::class, 'id', 'cabinet_id');
    }

    public function group()
    {
        return $this->hasOne(Group::class, 'id', 'group_id');
    }

    public static function getLessonTimes($week_day)
    {
        $week_day = WeekDays::where(['week_day_number' => $week_day])->first();
        $lesson_begin_time = strtotime($week_day->lesson_begin_time);
        $lesson_duration = $week_day->lesson_duration;
        $break_duration = $week_day->break_duration;
        $lesson_end_time = strtotime('20:00');
        $time = $week_day->lesson_begin_time;
        $times = [];

        while ($lesson_end_time >= strtotime($time)) {
            if (!is_numeric($time)) {
                $time = strtotime($time);
            }
            $added_lesson_duration = sprintf('+%s minutes', $lesson_duration);
            $added_break_duration = sprintf('+%s minutes', $break_duration);

            $time = date("H:i", strtotime($added_lesson_duration, $time));
            $time_duration = sprintf('%s-%s', date('H:i', $lesson_begin_time), $time);
            array_push($times, $time_duration);
            $time = date("H:i", strtotime($added_break_duration, strtotime($time)));
            $lesson_begin_time = strtotime($time);
        }

        return $times;
    }

    public static function getSchedule()
    {
        $weekDays = WeekDays::all();
        $result = [];
        $weekDaysArray = [];
        foreach ($weekDays as $day) {
            $schedules = [];
            $schedulesObject = Schedule::where(['week_day_id' => $day->id]);
            if (Auth::user()->hasRole('student')) {
                $schedulesObject =
                    $schedulesObject->
                    join('group_student', 'group_student.group_id', '=', 'schedules.group_id');
                if (Auth::user()->student) {
                    $schedulesObject = $schedulesObject->where('group_student.student_id', '=', Auth::user()->student->id);
                }
            }
            $schedulesObject = $schedulesObject->get();
            $weekDaysArray['title_kz'] = $day->title_kz;
            $weekDaysArray['title_ru'] = $day->title_ru;
            foreach ($schedulesObject as $schedule) {
                $scheduleArray = [];
                $teacher = ($schedule->group && $schedule->group && $schedule->group->teacher) ?
                    $schedule->group->teacher : null;
                $teacher = isset($teacher) ? sprintf('%s %s', $teacher->first_name, $teacher->last_name) : 'Не указано';
                $scheduleArray['subject_name'] = $schedule->group ? $schedule->group->name : 'Не указано';
                $scheduleArray['cabinet'] = $schedule->cabinet ? $schedule->cabinet->title : 'Не указано';
                $scheduleArray['teacher_name'] = $teacher;
                $scheduleArray['start_time'] = $schedule->lesson_begin_time;
                $scheduleArray['end_time'] = $schedule->lesson_end_time;
                array_push($schedules, $scheduleArray);
            }
            $weekDaysArray['schedule'] = $schedules;
            array_push($result, $weekDaysArray);
        }

        return $result;
    }
}
