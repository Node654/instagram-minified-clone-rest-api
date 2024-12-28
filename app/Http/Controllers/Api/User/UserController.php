<?php

namespace App\Http\Controllers\Api\User;

use App\Facades\User as UserFacade;
use App\Http\Controllers\Controller;
use App\Http\Middleware\User\CheckingWhetherUserCanSubscribeToAnotherUser;
use App\Http\Requests\User\GetUserPostsRequest;
use App\Http\Requests\User\UpdateAvatarRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\Subscriber\SubscribedResource;
use App\Http\Resources\User\CurrentUserPostsResource;
use App\Http\Resources\User\CurrentUserResource;
use App\Http\Resources\User\SubscriberResource;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class UserController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(CheckingWhetherUserCanSubscribeToAnotherUser::class, ['subscribe'])
        ];
    }

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

    public function subscribe(User $user)
    {
        $state = $user->subscribe();

        return SubscribedResource::make($state);
    }

    public function getUserPosts(GetUserPostsRequest $request, User $user): JsonResponse
    {
        return response()->json([
            'posts' => CurrentUserPostsResource::collection(UserFacade::getPosts($user, $request->limit(), $request->offset())),
            'total' => $user->totalPosts(),
        ]);
    }
}
