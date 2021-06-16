<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api;
use App\Http\Controllers\Api\BaseController;
use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends BaseController
{
    public function students(Request $request)
    {
        $group_id = $request->group_id;
        $group = Group::find($group_id);
        $students = $group->students;
        $list = [];
        foreach ($students as $student) {
            $list[$student->id] = sprintf('%s %s', $student->name, $student->last_name);
        }
        return $this->sendResponse($list);
    }
}
