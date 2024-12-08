<?php

namespace App\Http\Requests\User;

use App\Services\User\Data\RegisterUserData;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:234'],
            'email' => ['required', 'string', 'email', 'max:234', 'unique:users,email'],
            'login' => ['required', 'string', 'max:234', 'unique:users,login'],
            'about' => ['nullable', 'string', 'max:234'],
            'password' => ['required', 'string', 'confirmed'],
        ];
    }

    public function userRegisterData(): RegisterUserData
    {
        return RegisterUserData::from($this->validated());
    }
}
