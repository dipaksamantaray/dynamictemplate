<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Http\Controllers\PersonalAccessTokenController;
use Laravel\Passport\Http\Controllers\TransientTokenController;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use Laravel\Passport\Http\Controllers\AuthorizationController;
use Laravel\Passport\Http\Controllers\ClientController;


// Public routes
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
// Route::post('/oauth/token', [AccessTokenController::class, 'issueToken']);
// Route::post('/oauth/token/refresh', [AccessTokenController::class, 'refreshToken']);

// Authenticated routes
Route::middleware('auth:api')->group(function () {
    Route::post('token/refresh', [AuthController::class, 'refreshToken']);
    Route::post('token/generate', [AuthController::class, 'generateToken']);
    Route::get('protected-route/{id}', [AuthController::class, 'protectedRoute'])->middleware('scope:view-data');
    Route::post('create/customer', [AuthController::class, 'customercreate'])->middleware('scope:create-data');
    Route::post('edit/customer/{id}/{user_id}', [AuthController::class, 'customeredit'])->middleware('scope:edit-data');
    Route::get('delete/customer/{id}/{user_id}', [AuthController::class, 'delete'])->middleware('scope:delete-data');
});
