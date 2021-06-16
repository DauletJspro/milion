<?php


namespace App\Http\Controllers\Api;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends BaseController
{
    public function info()
    {
        $user = auth()->user() ? auth()->user()->toArray() : [];
        if (auth()->user()->hasRole('student')) {
            $user['advisor_user_id'] = (auth()->user()->student && auth()->user()->student->advisor &&
                auth()->user()->student->advisor->user) ? auth()->user()->student->advisor->user->id : null;
        } elseif (Auth::user()->hasRole('advisor')) {
            $studentsId = \auth()->user()->advisor->students->pluck('user_id')->toArray();
            $studentsUserId = User::whereIn('id', $studentsId)->get()->pluck('id')->toArray();
            $user['students_user_id'] = $studentsUserId;
        }

        return $this->sendResponse($user);
    }

    public function userById(Request $request)
    {
        $user_id = $request->id;
        $user = User::find($user_id);
        if (isset($user)) {
            return $this->sendResponse($user->toArray());
        }
        return $this->sendError('Такого пользователя нет');
    }

    public function all()
    {
        $users = User::all()->toArray();
        return $this->sendResponse($users);
    }
}
