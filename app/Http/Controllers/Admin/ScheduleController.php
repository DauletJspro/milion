<?php

namespace App\Http\Controllers\Admin;

use App\Models\Cabinet;
use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\WeekDays;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use function GuzzleHttp\Psr7\str;

class ScheduleController extends Controller
{
    public function show()
    {

        $week_days = WeekDays::where(['is_active' => true])->get();
        $cabinets = Cabinet::where(['is_active' => true])->get();

        $schedules = DB::table('schedules')
            ->where('is_active', '=', true)
            ->join('groups', 'schedules.group_id', '=', 'groups.id')
            ->join('subjects', 'groups.subject_id', '=', 'subjects.id');

        if (Auth::user()->hasRole('student')) {
            $schedules = $schedules
                ->join('group_student', 'group_student.group_id', '=', 'groups.id');
            if (Auth::user()->student) {
                $schedules = $schedules->where('group_student.student_id', '=', Auth::user()->student->id);
            }
        } elseif (Auth::user()->hasRole('teacher')) {
            if (Auth::user()->teacher) {
                $schedules = $schedules->where('groups.teacher_id', '=', Auth::user()->teacher->id);
            }
        }

        $schedules = $schedules->select('*', 'schedules.id as schedule_id')
            ->get();

        $schedules_array = [];
        foreach ($schedules as $schedule) {
            $time = sprintf('%s-%s', $schedule->lesson_begin_time, $schedule->lesson_end_time);
            $schedules_array[$schedule->week_day_id][$time][$schedule->cabinet_id] = [
                'group' => $schedule->name,
                'subject_title' => $schedule->title,
                'schedule_id' => $schedule->schedule_id
            ];
        }


        return view('schedule.show',
            [
                'week_days' => $week_days,
                'schedules_array' => $schedules_array,
                'table_cabinets' => $cabinets
            ]);
    }

    public
    function add_schedule(Request $request)
    {
        $validation = Validator::make($request->all(), Schedule::rules());
        if ($validation->fails()) {
            $request->session()->flash('danger', $validation->errors()->all());
            return back()->withInput();
        }


        DB::table('schedules')->insert([
            'week_day_id' => $request->week_day_id,
            'lesson_begin_time' => substr($request->lesson_time, 0, 5),
            'lesson_end_time' => substr($request->lesson_time, 6, 11),
            'cabinet_id' => $request->cabinet_id,
            'group_id' => $request->group_id,
            'created_at' => date('Y:m:d H:m:i'),
            'updated_at' => date('Y:m:d H:m:i'),
        ]);
        $request->session()->flash('success', 'Вы успешно добавили расписание.');
        return back();


    }

    public
    function delete_schedule_lesson(Request $request)
    {
        DB::table('schedules')->where(['id' => $request->schedule_id])->delete();
        $request->session()->flash('success', 'Вы успешно удалили урок.');
        return back();
    }

    public
    function get_lesson_data($schedule_id)
    {
        $schedule = Schedule::where(['id' => $schedule_id])->first();
        $result = [
            'day_of_week' => $schedule->day_of_week,
            'cabinet_id' => $schedule->cabinet_id,
            'time_duration' => sprintf('%s-%s', $schedule->lesson_begin_time, $schedule->lesson_end_time),
            'group_id' => $schedule->group_id,
            'schedule_id' => $schedule_id,
        ];

        return $result;
    }

    public function update_schedule_lesson(Request $request)
    {
        $group_id = $request->group_id;
        $schedule_id = $request->schedule_id;
        DB::table('schedules')->where('id', '=', $schedule_id)
            ->update(['group_id' => $group_id]);

        $request->session()->flash('success', 'Вы успешно изменили группу');
        return back();
    }

    public
    function get_lesson_begin_time($week_day)
    {
        $times = Schedule::getLessonTimes($week_day);
        return $times;
    }

    public
    function isAjax(Request $request)
    {
        $action = $request->action;
        $week_day = $request->week_day;
        $schedule_id = $request->schedule_id;
        switch ($action) {
            case 'get_lesson_begin_time':
                $result = $this->get_lesson_begin_time($week_day);
                break;
            case 'get_lesson_data':
                $result = $this->get_lesson_data($schedule_id);
                break;

        }
        return response()->json($result);
    }
}
