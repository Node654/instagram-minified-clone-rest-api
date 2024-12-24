<?php

namespace App\Services\User;

use App\Exceptions\User\InvalidUserCredentialsException;
use App\Http\Resources\User\CurrentUserResource;
use App\Models\User;
use App\Services\User\Data\LoginUserData;
use App\Services\User\Data\RegisterUserData;
use App\Services\User\Data\UpdateUserData;
use Illuminate\Http\UploadedFile;

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
        if (! auth()->guard('web')->attempt($data->toArray())) {
            throw new InvalidUserCredentialsException('Invalid credentials user', 401);
        }

        $token = auth()->user()->createToken('api_login');

        return [
            'token' => $token->plainTextToken,
        ];
    }

    public function updateAvatar(UploadedFile $image): User
    {
        auth()->user()->update([
            'avatar' => uploadedImage($image),
        ]);

        return auth()->user();
    }

    public function update(UpdateUserData $data): User
    {
        auth()->user()->update($data->toArray());

        return auth()->user();
    }
}
