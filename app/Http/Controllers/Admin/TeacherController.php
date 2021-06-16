<?php

namespace App\Http\Controllers\Admin;


use App\Models\Teacher;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::where(['is_active' => true])->get();
        return view('teacher.index', ['teachers' => $teachers]);
    }

    public function create()
    {
        return view('teacher.create');
    }

    public function store(Request $request)
    {
        $phone = (str_replace(['-', '(', ')', ' ', '+'], '', $request->phone));
        $request->merge([
            'phone' => $phone,
        ]);

        $data = $request;

        $validation = Validator::make($data->all(), (new Teacher())->rules());
        if ($validation->fails()) {
            $data->session()->flash('danger', $validation->errors()->all());
            return back()->withInput();
        }
        $password = Hash::make('62hello_world');
        $email = Str::random(8) . '@milion.com';

        try {
            DB::beginTransaction();
            $user = User::create([
                'name' => $data->first_name,
                'email' => $email,
                'password' => $password,
                'phone' => $data->phone,
            ]);
            $teacher = new Teacher();
            $teacher->user_id = $user->id;
            $teacher->is_active = true;
            $teacher->fill($data->all());
            $teacher->phone = $data->phone;
            $teacher->save();

            $user->assignRole('teacher');

            DB::commit();
            $data->session()->flash('success', 'Вы успешно добавили учителя!');
            return redirect(route('teacher.index'));

        } catch (\Exception $exception) {
            DB::rollback();
            $data->session()->flash('danger', [1 => $exception->getMessage()]);
            return back()->withInput();
        }
    }

    public function edit(Teacher $teacher)
    {
        return view('teacher.edit', compact('teacher'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $phone = (str_replace(['-', '(', ')', ' ', '+'], '', $request->phone));
        $request->merge([
            'phone' => $phone,
        ]);

        $data = $request;

        $validation = Validator::make($data->all(), (new Teacher())->updateRules());
        if ($validation->fails()) {
            $data->session()->flash('danger', $validation->errors()->all());
            return back()->withInput();
        }
        try {
            DB::beginTransaction();
            User::where(['id' => $teacher->user->id])
                ->update([
                    'name' => $data->first_name,
                    'phone' => $data->phone,
                ]);

            $teacher->fill($data->all());
            $teacher->phone = $data->phone;
            $teacher->save();

            DB::commit();
            $data->session()->flash('success', 'Вы успешно изменили учителя!');
            return back();

        } catch (\Exception $exception) {
            DB::rollback();
            $data->session()->flash('danger', [1 => $exception->getMessage()]);
            return back()->withInput();
        }
    }

    public function destroy(Teacher $teacher)
    {
        try {
            DB::beginTransaction();
            $teacher->delete();
            if (isset($teacher->user)) {
                $teacher->user->delete();
            }
            DB::commit();
            session()->flash('success', 'Вы успешно удалили учителя!');
            return redirect(route('teacher.index'));

        } catch (\Exception $exception) {
            DB::rollback();
            session()->flash('danger', [1 => $exception->getMessage()]);
            return back()->withInput();
        }
    }
}
