<?php

use App\Http\Controllers\Api\Post\PostController;
use Illuminate\Support\Facades\Route;

Route::apiResource('posts', PostController::class);
