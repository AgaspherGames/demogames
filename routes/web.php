<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\ScoreController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/login', [AdminController::class, 'showLogin'])->name('login');
Route::post('/login', [AdminController::class, 'login']);

Route::group(['middleware' => 'auth.admin'], function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');

    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::get('/user/{username}', [UserController::class, 'show'])->name('user');
    Route::post('/user/{username}/ban', [UserController::class, 'ban'])->name('ban');

    Route::get('/games', [GameController::class, 'index'])->name('games');
    Route::get('/games/{slug}', [GameController::class, 'show'])->name('game');
    Route::delete('/games/{slug}', [GameController::class, 'destroy']);

    Route::delete('/games/score/{id}', [ScoreController::class, 'deleteById'])->name('game.score');
    Route::delete('/games/score/game/{slug}', [ScoreController::class, 'deleteByGame'])->name('game.score.game');
    Route::delete('/games/score/game/{slug}/{id}', [ScoreController::class, 'deleteByUser'])->name('game.score.game.user');
});
