<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\TaskAssignmentController;
use App\Http\Controllers\TranscriptRequestController;
use App\Http\Controllers\UserController;
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

        Route::controller(UserController::class)->group(function () {
           
            Route::get('/users/change-password', 'showChangePasswordForm' )->name('change.password');
            Route::post('/users/change-password', 'processPasswordChange')->name('process.change.password');
            Route::get('/users/profile', 'showProfile' )->name('users.profile');
            // Route::get('/users', 'index')->name('auth.users');
            // Route::get('/users/select/{department_id}', 'showDepartmentUsers' )->name('users.selects.department');
            // Route::get('/users/change-password', 'showChangePasswordForm' )->name('users.change.password');
            // 
            // 
            // Route::post('/users/update/{id}', 'update')->name('users.update');
            // Route::post('/users/store', 'store')->name('users.store');
            // Route::post('/users/change/password', 'changePassword')->name('users.channge.password');
            // Route::post('/users/disable-account/{id}', 'disableAccount')->name('users.disable.account');
            // Route::post('/users/reset/{id}', 'resetPassword')->name('users.password.reset');
            // Route::get('/students', 'index')->name('student.users');
        });

        Route::controller(SchoolController::class)->group(function () {
            Route::get('/schools', 'index')->name('schools');
        });

        Route::controller(TaskAssignmentController::class)->group(function () {
            Route::get('/tasks', 'index')->name('tasks');
            Route::get('/tasks/{id}', 'viewTask')->name('view-tasks');
        });

        Route::controller(TranscriptRequestController::class)->group(function () {
            Route::get('/transcript-requests', 'index')->name('transcript-requests');
        });



    });
});
