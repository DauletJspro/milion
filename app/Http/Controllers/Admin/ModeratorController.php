<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ModeratorStoreRequest;
use App\Models\Advisor;
use App\Models\Moderator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ModeratorController extends Controller
{
    public function index()
    {
        $moderators = Moderator::all();
        return view('moderator.index', compact('moderators'));
    }

    public function create()
    {
        return view('moderator.create');
    }

    public function store(Request $request)
    {
        $phone = (str_replace(['-', '(', ')', ' ', '+'], '', $request->phone));
        $request->merge([
            'phone' => $phone,
        ]);
        $data = $request;

        $validation = Validator::make($data->all(), (new Moderator())->rules());
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
            $moderator = new Moderator();
            $moderator->user_id = $user->id;
            $moderator->is_active = true;
            $moderator->fill($data->all());
            $moderator->phone = $data->phone;
            $moderator->save();

            DB::commit();
            $data->session()->flash('success', 'Вы успешно добавили модератора!');
            return redirect(route('moderator.index'));

        } catch (\Exception $exception) {
            DB::rollback();
            $data->session()->flash('danger', [1 => $exception->getMessage()]);
            return back()->withInput();
        }

    }

    public function edit(Moderator $moderator)
    {
        return view('moderator.edit', compact('moderator'));
    }

    public function update(Request $request, Moderator $moderator)
    {
        $phone = (str_replace(['-', '(', ')', ' ', '+'], '', $request->phone));
        $request->merge([
            'phone' => $phone,
        ]);
        $data = $request;

        $validation = Validator::make($data->all(), (new Moderator())->updateRules());
        if ($validation->fails()) {
            $data->session()->flash('danger', $validation->errors()->all());
            return back()->withInput();
        }

        try {
            DB::beginTransaction();
            User::where(['id' => $moderator->user->id])
                ->update([
                    'name' => $data->first_name,
                    'phone' => $data->phone,
                ]);

            $moderator->fill($data->all());
            $moderator->save();

            DB::commit();
            $data->session()->flash('success', 'Вы успешно изменили модератора!');
            return redirect(route('moderator.index'));

        } catch (\Exception $exception) {
            DB::rollback();
            $data->session()->flash('danger', [1 => $exception->getMessage()]);
            return back()->withInput();
        }

    }

    public function destroy(Moderator $moderator)
    {
        try {
            DB::beginTransaction();
            if (isset($moderator->user)) {
                $moderator->user->delete();
                $moderator->delete();
            }
            DB::commit();
            session()->flash('success', 'Вы успешно удалили модератора!');
            return redirect(route('moderator.index'));
        } catch (\Exception $exception) {
            DB::rollBack();
            session()->flash('danger', [1 => $exception->getMessage()]);
            return back()->withInput();
        }
    }
}
