<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Subjects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class GroupController extends Controller
{
    public function index()
    {
        $groups = Group::all();
        return view('group.index', compact('groups'));
    }

    public function create()
    {
        return view('group.create');
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'teacher_id' => 'required',
            'subject_id' => 'required',
        ]);

        if ($validation->fails()) {
            $request->session()->flash('danger', $validation->errors()->all());
            return back()->withInput();
        }

        try {
            DB::beginTransaction();
            $group = new Group();
            $group->is_active = true;
            $group->fill($request->all());
            $group->save();

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            $request->session()->flash('danger', [1 => $exception->getMessage()]);
        }

        return redirect(route('group.index'));
    }

    public function edit(Group $group)
    {
        return view('group.edit', ['group' => $group]);
    }

    public function update(Request $request, Group $group)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'teacher_id' => 'required',
            'subject_id' => 'required',
        ]);

        if ($validation->fails()) {
            $request->session()->flash('danger', $validation->errors()->all());
            return back()->withInput();
        }

        try {
            DB::beginTransaction();
            $group->fill($request->all());
            $group->save();
            $request->session()->flash('success', 'Вы успешно изменили!');
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            $request->session()->flash('danger', [1 => $exception->getMessage()]);
        }

        return redirect(route('group.index'));
    }

    public function destroy(Group $group)
    {
        try {
            DB::beginTransaction();
            $group->delete();
            DB::commit();
            session()->flash('success', 'Вы успешно удалили группу!');
            return redirect(route('group.index'));

        } catch (\Exception $exception) {
            DB::rollBack();
            session()->flash('danger', [1 => $exception->getMessage()]);
            return back()->withInput();
        }
    }
}
