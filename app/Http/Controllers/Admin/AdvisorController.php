<?php

namespace App\Http\Controllers\Admin;

use App\Models\Advisor;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\Input;

class AdvisorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        $advisors = Advisor::where(['is_active' => true])->get();
        return view('advisor.index', ['advisors' => $advisors]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        return view('advisor.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $requests
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function store(Request $request)
    {
        $phone = (str_replace(['-', '(', ')', ' ', '+'], '', $request->phone));
        $request->merge([
            'phone' => $phone,
        ]);
        $data = $request;

        $validation = Validator::make($data->all(), (new Advisor)->rules());
        if ($validation->fails()) {
            $data->session()->flash('danger', $validation->errors()->all());
            return back()->withInput();
        }
        $email = Str::random(8) . '@milion.com';
        $password = Hash::make('62hello_world');


        try {
            DB::beginTransaction();
            $user = User::create([
                'name' => $data->first_name,
                'email' => $email,
                'password' => $password,
                'phone' => $data->phone,
            ]);
            $advisor = new Advisor();
            $advisor->user_id = $user->id;
            $advisor->is_active = true;
            $advisor->fill($data->all());
            $advisor->phone = $phone;
            $advisor->save();

            $user->assignRole('advisor');

            DB::commit();
            $data->session()->flash('success', 'Вы успешно добавили куратора!');
            return redirect(route('advisor.index'));

        } catch (\Exception $exception) {
            DB::rollback();
            $data->session()->flash('danger', [1 => $exception->getMessage()]);
            return back()->withInput();
        }

    }

    public function edit(Advisor $advisor)
    {
        return view('advisor.edit', compact('advisor'));
    }

    public function update(Request $request, Advisor $advisor)
    {
        $phone = (str_replace(['-', '(', ')', ' ', '+'], '', $request->phone));
        $request->merge([
            'phone' => $phone,
        ]);
        $data = $request;

        $validation = Validator::make($data->all(), (new Advisor)->updateRules());
        if ($validation->fails()) {
            $data->session()->flash('danger', $validation->errors()->all());
            return back()->withInput();
        }
        try {
            DB::beginTransaction();
            User::where(['id' => $advisor->user->id])->update([
                'name' => $data->first_name,
                'phone' => $data->phone,
            ]);
            $advisor->fill($data->all());
            $advisor->phone = $phone;
            $advisor->save();

            DB::commit();
            $data->session()->flash('success', 'Вы успешно изменили куратора!');
            return redirect(route('advisor.index'));

        } catch (\Exception $exception) {
            DB::rollback();
            $data->session()->flash('danger', [1 => $exception->getMessage()]);
            return back()->withInput();
        }
    }

    public function destroy(Advisor $advisor)
    {

        if (isset($advisor->students)) {
            session()->flash('danger', 'Данный куратор имеет студентов!');
            return redirect(route('advisor.index'));
        }
        try {
            DB::beginTransaction();
            $advisor->delete();
            if (isset($advisor->user)) {
                $advisor->user->delete();
            }
            DB::commit();
            session()->flash('success', 'Вы успешно изменили куратора!');
            return redirect(route('advisor.index'));

        } catch (\Exception $exception) {
            DB::rollback();
            session()->flash('danger', [1 => $exception->getMessage()]);
            return back()->withInput();
        }
    }
}
