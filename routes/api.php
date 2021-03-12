<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// Auth
Route::post('users', RegisterController::class);
Route::post('users/login', LoginController::class);

// User
Route::get('user', [UserController::class, 'index']);
Route::match(['put', 'patch'], 'user', [UserController::class, 'update']);

// Profiles
Route::get('profiles/{user}', [ProfileController::class, 'show']);
Route::post('profiles/{user}/follow', [ProfileController::class, 'follow']);
Route::delete('profiles/{user}/follow', [ProfileController::class, 'unFollow']);
