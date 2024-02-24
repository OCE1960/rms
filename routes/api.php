<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
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

Route::middleware('auth:sanctum')->group(function() {

    Route::controller(DashboardController::class)->group(function () {
        Route::post('/users', 'store')->name('users.store');
        Route::get('/users/{id}', 'viewUser')->name('users.show');
        Route::post('/users/update/{id}', 'update')->name('users.update');
    });

    Route::controller(UserController::class)->group(function () {
        Route::get('/users/show/{id}', 'viewStaff')->name('users.show');
        Route::post('/users/update_profile/{id}', 'updateProfile')->name('users.update.profile');
    });
});
