<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LeaveRequestController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/clear-cache', function () {
    Artisan::call('package:discover');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    // Artisan::call('clear:complied');
    return "Cache is cleared ... Check again";
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('dashboard')->group(function() {

    Route::middleware(['auth'])->group(function() {
        Route::controller(DashboardController::class)->group(function () {
            Route::get('/', 'index')->name('dashboard');
            Route::get('/users', 'getUsers')->name('users');
        });

        Route::controller(LeaveRequestController::class)->group(function () {
            Route::get('/leave-requests', 'index')->name('leave.requests');
        });
    });
});
