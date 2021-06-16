<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Group;
use App\Models\Schedule;
use App\Models\Student;
use Illuminate\Http\Request;

class AttendanceController extends BaseController
{

    public function dates(Request $request, $group_id = null)
    {
        $group_id = $request->group_id;
        $schedulesDate = Schedule::where(['group_id' => $group_id])->pluck('week_day_id')->toArray();
        if (empty($schedulesDate)) {
            return $this->sendError('Группа не найдена!');
        }
        $monthDays = $this->getMonthDays();
        foreach ($monthDays as $day) {
            $weekDay = date('w', strtotime($day));
            if (in_array($weekDay, $schedulesDate)) {
                $groupMonthDays[] = date('d-m', strtotime($day));
            }
        }
        return $this->sendResponse($groupMonthDays);
    }

    public function notes(Request $request)
    {
        $group_id = $request->group_id;
        $group = Group::find($group_id);
        $students = $group->students->toArray();

        $schedulesDate = Schedule::where(['group_id' => $group_id])->pluck('week_day_id')->toArray();
        $monthDays = $this->getMonthDays();
        foreach ($monthDays as $day) {
            $weekDay = date('w', strtotime($day));
            if (in_array($weekDay, $schedulesDate)) {
                $dates[] = date('Y-m-d', strtotime($day));
            }
        }

        $list = [];
        $firstDayOfMonth = $dates[0];
        $lastDayOfMonth = $dates[count($dates) - 1];
        foreach ($students as $student) {
            $studentAttendance = Attendance::where(['student_id' => $student['id']])
                ->where(['group_id' => $group_id])
                ->whereDate('attendance_date', '>=', date('Y-m-d', strtotime($firstDayOfMonth)))
                ->whereDate('attendance_date', '<=', date('Y-m-d', strtotime($lastDayOfMonth)))
                ->pluck('is_attended', 'attendance_date')->toArray();
            $attendance = [];

            foreach ($dates as $date) {
                $is_attended =
                    isset($studentAttendance[$date]) && $studentAttendance[$date]
                        ? true
                        : false;
                array_push($attendance, $is_attended);
            }
            $list[$student['id']] = $attendance;
        }


        return $this->sendResponse($list);
    }

    public
    function getMonthDays()
    {
        $list = array();
        $month = date('m');
        $year = date('Y');

        for ($d = 1; $d <= 31; $d++) {
            $time = mktime(12, 0, 0, $month, $d, $year);
            if (date('m', $time) == $month)
                $list[] = date('Y-m-d', $time);
        }

        return $list;
    }

    public
    function update(Request $request)
    {
        $group_id = $request->group_id;
        $group = Group::find($group_id);
        $attendances = $request->attendances;
        $schedulesDate = Schedule::where(['group_id' => $group_id])->pluck('week_day_id')->toArray();
        $monthDays = $this->getMonthDays();
        foreach ($monthDays as $day) {
            $weekDay = date('w', strtotime($day));
            if (in_array($weekDay, $schedulesDate)) {
                $dates[] = $day;
            }
        }

        $students = $group->students;
        foreach ($students as $student) {
            foreach ($dates as $key => $date) {
                Attendance::create([
                    'group_id' => $group_id,
                    'student_id' => $student->id,
                    'is_attended' => ($attendances[$student->id][$key] ? true : false),
                    'attendance_date' => $date,
                ]);
            }
        }

        return $this->sendResponse([]);


    }
}
