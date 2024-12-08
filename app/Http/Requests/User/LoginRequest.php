<?php

namespace App\Http\Requests\User;

use App\Services\User\Data\LoginUserData;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['nullable', 'string', 'email', 'max:255'],
            'login' => ['nullable', 'string', 'max:255'],
            'password' => ['required', 'string'],
        ];
    }

    public function userLoginData(): LoginUserData
    {
        return LoginUserData::from($this->validated());
    }
}
