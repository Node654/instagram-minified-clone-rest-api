<?php

namespace App\Http\Requests\User;

use App\Services\User\Data\UpdateUserData;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|unique:users,email|max:255',
            'login' => 'nullable|string|unique:users,login|max:255',
            'about' => 'nullable|string|max:255',
            'password' => 'nullable|string|max:255|confirmed',
        ];
    }

    public function userData(): UpdateUserData
    {
        return UpdateUserData::from($this->validated());
    }
}
