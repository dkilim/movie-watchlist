<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WatchlistController;
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

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);


/** AUTHORIZATION AND AUTHENTICATION */
Route::middleware(['auth:api'])->group(function ()
{
    Route::get('user', [AuthController::class, 'user']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::put('users/info', [AuthController::class, 'updateInfo']);
    Route::put('users/password', [AuthController::class, 'updatePassword']);
    Route::get('permission', [PermissionController::class, 'index']);

    Route::apiResource('roles', RoleController::class);

});


Route::middleware(['auth:api'])->group(function ()
{
    Route::apiResource('users', UserController::class);
    Route::apiResource('movies', MovieController::class);
    Route::apiResource('watchlist', WatchlistController::class);

});


