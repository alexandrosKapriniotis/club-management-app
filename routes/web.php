<?php

use App\Http\Controllers\ClubController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\SportMatchController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Auth;
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
Auth::routes();

Route::group(['middleware'=> 'auth'], function () {
    Route::get('/', [DashboardController::class, 'index']);
    Route::resource('teams', TeamController::class);
    Route::resource('clubs', ClubController::class);
    Route::resource('players', PlayerController::class);
    Route::resource('matches', SportMatchController::class);
});

