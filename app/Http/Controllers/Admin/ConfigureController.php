<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WeekDays;
use Illuminate\Http\Request;

class ConfigureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        return view('system_configuration.configuration');
    }


    public function show_week_days()
    {
        $week_days = WeekDays::all();
        return view('system_configuration.week_days', ['week_days' => $week_days]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $days = [1, 2, 3, 4, 5, 6, 7];
        $times = $request->all();
        foreach ($days as $day) {
            // Extract digit from input
            preg_match('!\d+!', (substr($times['lesson_duration:' . $day], 0, 3)), $lesson_duration);
            preg_match('!\d+!', (substr($times['break_duration:' . $day], 0, 3)), $break_duration);
            $lesson_begin_time = $times['lesson_begin_time:' . $day];
            WeekDays::where(['week_day_number' => $day])->update([
                'lesson_duration' => $lesson_duration[0],
                'break_duration' => $break_duration[0],
                'lesson_begin_time' => str_replace('-',':', $lesson_begin_time),
            ]);
        }

        $request->session()->flash('success', 'Изменения были успешно сохранены');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
