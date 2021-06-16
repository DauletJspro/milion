<?php

namespace App\Http\Controllers\Admin;

use App\Models\Advisor;
use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\GroupStudent;
use App\Models\Student;
use App\Models\StudentSubject;
use App\Models\Subjects;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        $students = Student::all();
        return view('students.index', ['students' => $students]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        return view('students.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $phone = (str_replace(['-', '(', ')', ' ', '+'], '', $request->phone));
        $request->merge([
            'phone' => $phone,
        ]);
        $data = $request;

        $validation = Validator::make($data->all(), (new Student())->rules());
        if ($validation->fails()) {
            $data->session()->flash('danger', $validation->errors()->all());
            return back()->withInput();
        }

        try {
            DB::begintransaction();
            $email = Str::random(8);
            $email = $email . '@milion.com';
            $password = '62hello_world';
            $password = Hash::make($password);


            $user = User::create([
                'name' => $data->name,
                'email' => $email,
                'password' => $password,
                'phone' => $data->phone,
            ]);

            $user->assignRole('student');

            $student = new Student();
            $student->fill($data->all());
            $student->phone = $phone;
            $student->user_id = $user->id;
            $student->save();

            $groups = Group::whereIn('id', $data->groups)->get();

            foreach ($groups as $group) {
                DB::table('student_subject')->insert([
                    'student_id' => $student->id,
                    'subject_id' => $group->subject->id,
                ]);

                if (!isset($group->subject)) {
                    $data->session()->flash('danger', [1 => 'Предмет группы не существует!']);
                    return redirect(route('student.index'));
                }

                DB::table('group_student')->insert([
                    'student_id' => $student->id,
                    'group_id' => $group->id,
                ]);
            }


            DB::commit();

            $data->session()->flash('success', 'Вы успешно добавили студента!');
            return redirect(route('student.index'));

        } catch (\Exception $e) {
            DB::rollback();
            $data->session()->flash('danger', [1 => $e->getMessage()]);
            return back()->withInput();
        }
    }

    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $phone = (str_replace(['-', '(', ')', ' ', '+'], '', $request->phone));
        $request->merge([
            'phone' => $phone,
        ]);
        $data = $request;

        $validation = Validator::make($data->all(), (new Student())->updateRules());
        if ($validation->fails()) {
            $data->session()->flash('danger', $validation->errors()->all());
            return back()->withInput();
        }

        try {
            DB::begintransaction();


            User::where(['id' => $student->user->id])->update([
                'name' => $data->name,
                'phone' => $data->phone,
            ]);

            $student->fill($data->all());
            $student->phone = $phone;
            $student->save();


            $studentSubjects = StudentSubject::where(['student_id' => $student->id])
                ->get();

            if (isset($studentSubjects)) {
                StudentSubject::destroy($studentSubjects->pluck('id')->toArray());
            }

            $studentGroup = GroupStudent::where(['student_id' => $student->id])
                ->get();

            if (isset($studentGroup)) {
                GroupStudent::destroy($studentGroup->pluck('id')->toArray());
            }

            $groups = Group::whereIn('id', $data->groups)->get();

            foreach ($groups as $group) {
                DB::table('student_subject')->insert([
                    'student_id' => $student->id,
                    'subject_id' => $group->subject->id,
                ]);

                if (!isset($group->subject)) {
                    $data->session()->flash('danger', [1 => 'Предмет группы не существует!']);
                    return redirect(route('student.index'));
                }

                DB::table('group_student')->insert([
                    'student_id' => $student->id,
                    'group_id' => $group->id,
                ]);
            }

            DB::commit();

            $data->session()->flash('success', 'Вы успешно добавили студента!');
            return redirect(route('student.index'));

        } catch (\Exception $e) {
            DB::rollback();
            $data->session()->flash('danger', [1 => $e->getMessage()]);
            return back()->withInput();
        }
    }

    public function destroy(Student $student)
    {
        try {
            DB::beginTransaction();
            $student->delete();
            if (isset($student->user)) {
                $student->user->delete();
            }
            DB::commit();
            session()->flash('success', 'Вы успешно удалили студента!');
            return redirect(route('student.index'));

        } catch (\Exception $exception) {
            DB::rollback();
            session()->flash('danger', [1 => $exception->getMessage()]);
            return back()->withInput();
        }
    }

    public function debt(Request $request)
    {
        $debt = $request->debt;
        $user = User::find($request->id);
        $user->debt = $debt;
        $user->save();
        session()->flash('success', 'Вы успешно добавили задолжность!');
        return redirect(route('student.index'));
    }
}
