<?php


namespace App\Patterns\Profile\Classes;


use App\Patterns\Profile\Interfaces\Profile;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AdvisorProfile implements Profile
{

    public function getRelation()
    {
        $user = Auth::user();
        return $user->advisor;
    }

    public function validate(Request $request): array
    {

    }

    public function update(Request $request): array
    {

    }


}
