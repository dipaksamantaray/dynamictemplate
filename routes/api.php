<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataFeedController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\ApiAuthController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PassportController;




// Registration and login endpoints for API
Route::post('/register', [ApiAuthController::class, 'register']);
Route::post('/login', [ApiAuthController::class, 'login']);

// Protected API routes
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {

    Route::get('/profile',[PassportController::class,'profile'])->name('profile');
    Route::get('/admin/index',[PassportController::class,'adminindex'])->name('admin.index');
    Route::post('admins/create',[PassportController::class,'admincreate'])->name('admin.store');

});
