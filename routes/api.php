<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
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

// Public routes
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'loginUser']);
Route::get('/users', [UserController::class, 'getAllUser']);

// protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
  Route::post('/logout', [AuthController::class, 'logout']);
  Route::put('/user/{id}', [UserController::class, 'updateUser']);
  Route::get('/user/{id}', [UserController::class, 'getUserById']);
  Route::delete('/user/{id}', [UserController::class, 'deleteUser']); 
});
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
