<?php

namespace App\Facades;

use App\Http\Resources\User\CurrentUserResource;
use App\Services\User\Data\LoginUserData;
use App\Services\User\Data\RegisterUserData;
use App\Services\User\Data\UpdateUserData;
use App\Services\User\UserService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Facade;

/**
 * @method static CurrentUserResource store(RegisterUserData $data)
 * @method static array login(LoginUserData $data)
 * @method static \App\Models\User updateAvatar(UploadedFile $image)
 * @method static \App\Models\User update(UpdateUserData $data)
 * @method static Collection getPosts(\App\Models\User $user, int $limit = 10, int $offset = 0)
 * @method static int totalCurrentUserPosts()
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
