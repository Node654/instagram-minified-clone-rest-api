<?php

namespace App\Http\Controllers\Api\User;

use App\Facades\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateAvatarRequest;
use App\Http\Resources\User\CurrentUserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserController extends Controller
{

    public function user(): JsonResource
    {
        return new CurrentUserResource(auth()->user());
    }

    public function updateAvatar(UpdateAvatarRequest $request): JsonResource
    {
        return new CurrentUserResource(User::updateAvatar($request->avatar()));
    }
}
