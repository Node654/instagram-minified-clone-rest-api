<?php

use App\Http\Controllers\Api\Login\LoginController;
use App\Http\Controllers\Api\Register\RegisterController;
use App\Http\Controllers\Api\User\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('user')->as('users.')->group(function () {
    Route::post('/register', RegisterController::class)->name('register');
    Route::post('/login', LoginController::class)->name('login');
    Route::controller(UserController::class)->group(function () {
        Route::get('/', 'user')->name('current');
        Route::patch('/', 'update')->name('update');
        Route::post('/avatar', 'updateAvatar')->name('update.current-user.avatar');
    });
});
