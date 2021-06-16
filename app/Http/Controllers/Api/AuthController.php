<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;

class AuthController extends BaseController
{
    public function login(LoginRequest $request)
    {

        if (isset($request->validator) && $request->validator->fails()) {
            return $this->sendError($request->validator->messages());
        }

        if (!auth()->attempt($request->all())) {
            return $this->sendError(['message' => 'Invalid Credentials']);
        }

        $token = auth()->user()->createToken('authToken')->accessToken;

        $result = [
            'user' => auth()->user(),
            'token' => $token,
        ];

        return $this->sendResponse($result);
    }
}
