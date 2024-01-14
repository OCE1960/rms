<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LeaveRequestController;
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

    Route::controller(LeaveRequestController::class)->group(function () {
        Route::get('/leave-requests/{id}', 'viewLeaveRequest')->name('view.leave.requests');
        Route::post('/leave-requests/{id}', 'processLeaveRequestApproval')->name('leave.requests.approval');
        Route::post('/leave-requests', 'store')->name('leave.requests.store');
    });
});
