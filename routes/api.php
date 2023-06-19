<?php

use App\Http\Controllers\Api\GameController;
use App\Http\Controllers\Api\ScoreController;
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
    Route::get('/games/{slug}', [GameController::class, 'show']);
    Route::get('/games/{slug}/scores', [ScoreController::class, 'show']);
    Route::group(["middleware" => 'auth:sanctum'], function () {
        Route::post('/games/{slug}/scores', [ScoreController::class, 'create']);
        Route::post('/games', [GameController::class, 'store']);
        Route::post('/games/{slug}/upload', [GameController::class, 'upload']);
        Route::put('/games/{slug}', [GameController::class, 'update']);
        Route::delete('/games/{slug}', [GameController::class, 'delete']);
    });

    Route::get('/users/{username}', [UserController::class, 'show']);

});
