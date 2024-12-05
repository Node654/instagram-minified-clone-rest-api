<?php

use App\Http\Controllers\Api\Register\RegisterController;
use App\Http\Controllers\Api\Login\LoginController;
use Illuminate\Support\Facades\Route;

Route::prefix('user')->as('users.')->group(function () {
    Route::post('/register', RegisterController::class)->name('register');
    Route::post('/login', LoginController::class)->name('login');
});
