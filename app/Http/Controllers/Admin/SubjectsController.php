<?php

namespace App\Http\Controllers\Admin;

use App\Models\Group;
use App\Http\Controllers\Controller;
use App\Models\Subjects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SubjectsController extends Controller
{
    public function index()
    {
        $subjects = Subjects::all();
        $currentUser = Auth::user();
        if ($currentUser->student) {
            $subjects = $currentUser->student->subjects;
        } elseif ($currentUser->teacher) {
            $subjects = $currentUser->teacher->subjects;
        }
        return view('subject.index', ['subjects' => $subjects]);
    }

    public function create()
    {
        return view('subject.create');
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), ['title' => 'required']);
        if ($validation->fails()) {
            $request->session()->flash('danger', $validation->errors()->all());
            return back()->withInput();
        }

        try {
            DB::beginTransaction();
            $subject = new Subjects();
            $subject->fill($request->all());
            $subject->save();


            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            $request->session()->flash('danger', [1 => $exception->getMessage()]);
        }


        return redirect(route('subject.index'));

    }

    public function edit(Subjects $subject)
    {
        return view('subject.edit', compact('subject'));
    }

    public function update(Request $request, Subjects $subject)
    {
        $validation = Validator::make($request->all(), ['title' => 'required']);
        if ($validation->fails()) {
            $request->session()->flash('danger', $validation->errors()->all());
            return back()->withInput();
        }
        try {
            DB::beginTransaction();
            $subject->fill($request->all());
            $subject->save();

            DB::commit();

            session()->flash('success', 'Вы успешно редактировали предмет!');
            return redirect(route('subject.index'));
        } catch (\Exception $exception) {
            DB::rollBack();
            $request->session()->flash('danger', [1 => $exception->getMessage()]);
        }
    }

    public function destroy(Subjects $subject)
    {
        try {
            DB::beginTransaction();
            if (isset($subject->group)) {
                $subject->group->delete();
            }
            $subject->delete();
            DB::commit();
            session()->flash('success', 'Вы успешно удалили предмет!');
            return redirect(route('subject.index'));

        } catch (\Exception $exception) {
            DB::rollBack();
            session()->flash('danger', [1 => $exception->getMessage()]);
            return back()->withInput();
        }
    }
}
