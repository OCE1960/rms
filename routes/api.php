<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskAssignmentController;
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

    Route::controller(TaskAssignmentController::class)->group(function () {
        Route::post('/compile-results', 'processCompileResult')->name('compile-results');
        Route::post('/check-compile-results', 'processCheckCompileResult')->name('check-compile-results');
        Route::post('/recommend-compile-results', 'processRecommendCompileResult')->name('recommend-compile-results');
        Route::post('/approve-compile-results', 'processApproveCompileResult')->name('approve-compile-results');
        Route::post('/dispatch-compile-results', 'processDispatchCompileResult')->name('dispatch-compile-results');
        Route::post('/archive-compile-results', 'processArchivedTrancriptRequest')->name('archive-compile-results');
        Route::post('/verify-results', 'processVerifyResult')->name('verify-results');
        Route::post('/check-verify-results', 'processCheckVerifyResult')->name('check-verify-results');
        Route::post('/recommend-verify-results', 'processRecommendVerifyResult')->name('recommend-verify-results');
        Route::post('/approve-verify-results', 'processApproveVerifyResult')->name('approve-verify-results');
        Route::post('/dispatch-verify-results', 'processDispatchVerifyResult')->name('dispatch-verify-results');
    });
});
