<?php

namespace App\Services\User;

use App\Exceptions\User\InvalidUserCredentialsException;
use App\Http\Resources\User\CurrentUserResource;
use App\Models\User;
use App\Services\User\Data\LoginUserData;
use App\Services\User\Data\RegisterUserData;

class UserService
{
    public function store(RegisterUserData $data): CurrentUserResource
    {
        return new CurrentUserResource(User::query()->create($data->toArray()));
    }

    /**
     * @throws InvalidUserCredentialsException
     */
    public function login(LoginUserData $data): array
    {
        if (! auth()->guard('web')->attempt($data->toArray()))
        {
            throw new InvalidUserCredentialsException('Invalid credentials user', 401);
        }

        return [
            'token' => 1
        ];
    }
}
