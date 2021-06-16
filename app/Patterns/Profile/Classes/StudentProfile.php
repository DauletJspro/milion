<?php


namespace App\Patterns\Profile\Classes;


use App\Helpers\ResponseFormatHelper;
use App\Patterns\Profile\Interfaces\Profile;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class StudentProfile implements Profile
{

    public function getRelation()
    {
        $user = Auth::user();
        return $user->student;
    }

    public function validate(Request $request): array
    {
        $passwordRules = [];
        if ($request->password || $request->password_confirmation) {
            $passwordRules = [
                'password' => 'required|confirmed|min:8',
            ];
        }
        $rules = array_merge([
            'first_name' => 'required|max:32',
            'last_name' => 'required|max:32',
            'middle_name' => 'required|max:32',
            'address' => 'required|max:100',
        ], $passwordRules);

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errorString = '';
            foreach ($errors as $error) {
                $errorString .= $error . ' ';
            }
            return ResponseFormatHelper::responseFormat(false, [], $errorString);
        }
        return ResponseFormatHelper::responseFormat(true);
    }

    public function update(Request $request): array
    {
        try {
            DB::beginTransaction();
            Student::where('user_id', Auth::user()->id)->update([
                'name' => $request->first_name,
                'last_name' => $request->last_name,
                'middle_name' => $request->middle_name,
                'address' => $request->address,
            ]);

            if ($request->password && $request->password_confirmation) {
                Auth::user()->password = Hash::make($request->password);
            }

            Auth::user()->name = $request->first_name;
            Auth::user()->save();
            DB::commit();
            return ResponseFormatHelper::responseFormat(true);
        } catch (\Exception $exception) {
            DB::rollBack();
            return ResponseFormatHelper::responseFormat(false, [], $exception->getMessage());
        }


    }


}
