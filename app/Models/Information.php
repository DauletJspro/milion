<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Information extends Model
{
    public function get_items()
    {
        $result = cache()->remember('test_count', '300', function () {

            $currentUser = Auth::user();
            $user_count = User::all()->count();
            $student_count = User::join('students', 'users.id', '=', 'students.user_id')
                ->count();

            $advisor_count = User::join('advisors', 'users.id', '=', 'advisors.user_id')
                ->count();

            $teacher_count = User::join('teachers', 'users.id', '=', 'teachers.user_id')
                ->count();

            $group_count = Group::all()->count();
            $subject_count = Subjects::all()->count();

            if ($currentUser->hasRole('student')) {
                $group_count = Auth::user()->student && Auth::user()->student->groups ? count(Auth::user()->student->groups->toArray()) : 0;
                $subject_count = Auth::user()->student && Auth::user()->student->subjects ? count(Auth::user()->student->subjects->toArray()) : 0;
            } elseif ($currentUser->hasRole('teacher')) {
                $group_count = Auth::user()->teacher && Auth::user()->teacher->groups ? count(Auth::user()->teacher->groups->toArray()) : 0;
                $subject_count = Auth::user()->teacher && Auth::user()->teacher->subjects ? count(Auth::user()->teacher->subjects->toArray()) : 0;
            }


            $news_count = News::all()->count();

            $result = [
                'user_count' => $user_count,
                'student_count' => $student_count,
                'advisor_count' => $advisor_count,
                'teacher_count' => $teacher_count,
                'group_count' => $group_count,
                'subject_count' => $subject_count,
                'news_count' => $news_count
            ];
            return $result;
        });

        return $result;
    }

    public static function getRegisteredCount(int $week_number, $type)
    {
        $weekDays = [];
        $date_string = sprintf("%s weeks last Monday", $week_number);

        if ($week_number == 0) {
            $date_string = "last monday";
        }

        $last_monday = date('d-m-Y', strtotime($date_string));

        $ts = strtotime($last_monday);
        $year = date('o', $ts);
        $week = date('W', $ts);
        for ($i = 1; $i <= 7; $i++) {
            $week_day = strtotime($year . 'W' . $week . $i);
            $week_day = date("Y-m-d", $week_day);
            $weekDays[] = $week_day;
        }


        $object = new User();

        $registered_count = $object->whereYear('created_at', '=', date('Y', strtotime($weekDays[0])))
            ->whereMonth('created_at', '=', date('m', strtotime($weekDays[0])))
            ->whereDay('created_at', '>=', date('d', strtotime($weekDays[0])))
            ->whereDay('created_at', '<=', date('d', strtotime($weekDays[6])))
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as item_count'))
            ->groupBy('date')
            ->get()
            ->pluck('item_count', 'date')
            ->toArray();


        $registered_count = array_map(function ($item) use ($registered_count) {
            return ($registered_count[$item]) ?? 0;
        }, $weekDays);

        return [
            'weekDays' => $weekDays,
            'registered_count' => $registered_count,
            'week_number' => $week_number,
            'type' => $type,
        ];
    }
}
