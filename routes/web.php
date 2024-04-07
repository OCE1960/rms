<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ResultVerificationRequestController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StudentController;
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
            Route::get('/users/students', 'getStudents')->name('users.students');
            Route::get('/users/staffs', 'getStaffs')->name('users.staffs');
            Route::get('/users/result-enquirers', 'getResultEnquirers')->name('users.result.enquirers');
            Route::get('/users/students/{id}', 'viewStudent')->name('web.users.show');
            // Route::post('/users/disable-account/{id}', 'disableAccount')->name('users.disable.account');
        });

        Route::controller(SchoolController::class)->group(function () {
            Route::get('/schools', 'index')->name('schools');
            Route::get('/schools/{id}', 'viewSchool')->name('web.schools.show');
        });

        Route::controller(StudentController::class)->group(function () {
            Route::get('/students', 'index')->name('students');
        });

        Route::controller(CoursesController::class)->group(function () {
            Route::get('/courses', 'index')->name('courses');
        });

        Route::controller(SemesterController::class)->group(function () {
            Route::get('/semesters', 'index')->name('semesters');
        });

        Route::controller(StaffController::class)->group(function () {
            Route::get('/staffs', 'index')->name('staffs');
        });

        Route::controller(TaskAssignmentController::class)->group(function () {
            Route::get('/tasks', 'index')->name('tasks');
            Route::get('/tasks/{id}', 'viewTask')->name('view-tasks');
        });

        Route::controller(TranscriptRequestController::class)->group(function () {
            Route::get('/transcript-requests', 'index')->name('transcript-requests');
        });

        Route::controller(ResultVerificationRequestController::class)->group(function () {
            Route::get('/verification-requests', 'index')->name('verification-requests');
        });

    });
});
