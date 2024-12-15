<?php

namespace App\Facades;

use App\Http\Resources\User\CurrentUserResource;
use App\Services\User\Data\LoginUserData;
use App\Services\User\Data\RegisterUserData;
use App\Services\User\Data\UserAvatarData;
use App\Services\User\UserService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Facade;

/**
 * @method static CurrentUserResource store(RegisterUserData $data)
 * @method static array login(LoginUserData $data)
 * @method static \App\Models\User updateAvatar(UploadedFile $image)
 *
 * @see UserService
 */
class User extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return UserService::class;
    }
}
