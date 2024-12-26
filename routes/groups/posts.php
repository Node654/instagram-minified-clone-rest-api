<?php

use App\Http\Controllers\Api\Post\PostController;
use Illuminate\Support\Facades\Route;

Route::apiResource('posts', PostController::class);
Route::controller(PostController::class)
    ->prefix('posts')
    ->as('posts.')
    ->group(function () {
        Route::post('/{post}/comments', 'storeComment')->name('comments-store');
    });
