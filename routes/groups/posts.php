<?php

use App\Http\Controllers\Api\Post\PostController;
use Illuminate\Support\Facades\Route;

Route::apiResource('posts', PostController::class)->middleware(['auth:sanctum']);
Route::controller(PostController::class)
    ->middleware(['auth:sanctum'])
    ->prefix('posts')
    ->as('posts.')
    ->group(function () {
        Route::post('/{post}/comments', 'storeComment')->name('comments-store');
    });
