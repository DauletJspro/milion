<?php

namespace App\Http\Controllers\Admin;


use App\Helpers\ResponseFormatHelper;
use App\Http\Controllers\Common\FileController;
use App\Http\Controllers\Controller;
use App\Patterns\Profile\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use function Symfony\Component\String\s;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        $role = $this->getRole();
        if (Auth::user()->hasRole('admin')) {
            return redirect(route('information.index'));
        }
        $currentUser = (new \App\Patterns\Profile\Factory)->getItem($role)->getRelation();
        return view('profile.show', ['currentUser' => $currentUser]);
    }

    private function update($request)
    {
        $role = $this->getRole();

        $validate = (new \App\Patterns\Profile\Factory)->getItem($role)->validate($request);
        if (!$validate['success']) return $validate;

        $updated = (new \App\Patterns\Profile\Factory)->getItem($role)->update($request);
        if (!$updated['success']) return $updated;

        $moveImageFromTemp = app((new \App\Http\Controllers\Common\FileController)->moveFileFromTemp($request));

        return ResponseFormatHelper::responseFormat(true, [], 'Вы успешно изменили профиль');
    }

    public function isAjax(Request $request)
    {
        $action = $request->action;
        switch ($action) {
            case 'update_student':
                $result = $this->update($request);
        }

        return response()->json($result);
    }

    public function getRole()
    {
        $roles = Auth::user()->roles->pluck('id')->toArray();
        if (!empty($roles)) {
            return $roles[0];
        }
        return null;
    }
}
