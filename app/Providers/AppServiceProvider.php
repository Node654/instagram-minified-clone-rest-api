<?php

namespace App\Providers;

use App\Http\Resources\Post\FeedPostResource;
use App\Http\Resources\User\CurrentUserResource;
use App\Services\Comment\CommentService;
use App\Services\User\UserService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserService::class, UserService::class);
        $this->app->bind(CommentService::class, CommentService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        CurrentUserResource::withoutWrapping();
    }
}
