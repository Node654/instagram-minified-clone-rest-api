<?php

namespace App\Http\Controllers\Api\Login;

use App\Facades\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginRequest;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request): array
    {
        return User::login($request->userLoginData());
    }
}
