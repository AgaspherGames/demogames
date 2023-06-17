<?php

use App\Http\Controllers\Api\GameController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('/v1')->group(function () {

    Route::prefix('/auth')->group(function () {
        Route::post('/signup', [UserController::class, 'signup']);
        Route::post('/signin', [UserController::class, 'signin']);
        Route::group(["middleware" => 'auth:sanctum'], function () {
            Route::post('/signout', [UserController::class, 'signout']);
        });
    });

    Route::get('/games', [GameController::class, 'index']);
});
