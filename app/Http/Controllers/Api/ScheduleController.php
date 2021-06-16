<?php


namespace App\Http\Controllers\Api;


use App\Models\Schedule;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends BaseController
{

    public function schedule()
    {
        $schedule = Schedule::getSchedule();
        return $this->sendResponse($schedule);
    }
}
