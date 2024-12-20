<?php

namespace App\Http\Controllers\Api\User;

use App\Facades\User as UserFacade;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateAvatarRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\User\CurrentUserResource;
use App\Http\Resources\User\SubscriberResource;
use App\Http\Resources\User\UserResource;
use App\Models\Subscriber;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class UserController extends Controller
{
    public function user(): JsonResource
    {
        return new CurrentUserResource(auth()->user());
    }

    public function updateAvatar(UpdateAvatarRequest $request): JsonResource
    {
        return new CurrentUserResource(UserFacade::updateAvatar($request->avatar()));
    }

    public function update(UpdateUserRequest $request): JsonResource
    {
        return new CurrentUserResource(UserFacade::update($request->userData()));
    }

    public function getUser(User $user)
    {
        return new UserResource($user);
    }

    public function subscribers(User $user)
    {
        return SubscriberResource::collection($user->subscribers);
    }
}
