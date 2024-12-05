<?php

namespace App\Facades;

use App\Http\Resources\User\CurrentUserResource;
use App\Services\User\Data\LoginUserData;
use App\Services\User\Data\RegisterUserData;
use App\Services\User\UserService;
use Illuminate\Support\Facades\Facade;

/**
 * @method static CurrentUserResource store(RegisterUserData $data)
 * @method static CurrentUserResource login(LoginUserData $data)
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
