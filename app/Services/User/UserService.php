<?php

namespace App\Services\User;

use App\Exceptions\User\InvalidUserCredentialsException;
use App\Http\Resources\User\CurrentUserResource;
use App\Models\User;
use App\Services\User\Data\LoginUserData;
use App\Services\User\Data\RegisterUserData;
use App\Services\User\Data\UserAvatarData;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

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

        $token = auth()->user()->createToken('api_login');

        return [
            'token' => $token->plainTextToken
        ];
    }

    public function updateAvatar(UploadedFile $image): User
    {
        $path = $image->storePublicly('avatars');
        $url = config('app.url') . '/storage/' . $path;
        auth()->user()->update([
            'avatar' => $url
        ]);
        return auth()->user();
    }
}
