<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GalleriesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentsController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/galleries', [GalleriesController::class, 'index']);
Route::get('/galleries/{id}', [GalleriesController::class, 'show']);
Route::post('/galleries/{id}/comments', [CommentsController::class, 'store']);
Route::post('/galleries', [GalleriesController::class, 'store']);

// User
Route::get('/authors/{id}', [UserController::class, 'show']);

// LoginOrRegister
Route::post('/login', [AuthController::class, 'login']);
Route::get('/user', [AuthController::class, 'loggedUser']);
Route::post('/refresh-token', [AuthController::class, 'refreshToken']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::post('/register', [AuthController::class, 'register']);