<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function show()
    {
        $currentUser = Auth::user();
        $groups = Group::all();
        if ($currentUser->hasRole('teacher')) {
            $groups = $currentUser->teacher->groups();
        }

        return view('attendance.groups', compact('groups'));
    }

    public function table()
    {
        return view('attendance.table');
    }

    public function dates(Request $request)
    {
        $group_id = $request->group_id;

        $schedules = Schedule::where(['group_id' => $group_id])->pluck('week_day_id')->toArray();

        var_dump($schedules);
        die();

    }
}
