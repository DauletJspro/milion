<?php


namespace App\Patterns\Profile\Interfaces;


use App\User;
use Illuminate\Http\Request;

interface Profile
{

    public function getRelation();

    public function validate(Request $request): array;

    public function update(Request $request): array;
}
