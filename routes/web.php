<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EnquirerController;
use App\Http\Controllers\ResultVerificationRequestController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\Auth\StudentLoginController;
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

Route::get('/db-seed', function () {
    Artisan::call('migrate:fresh --seed');
    return "Migration Complete ... Check again";
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('students')->group(function() {
    Route::controller(UserController::class)->group(function () {
        Route::get('/login', 'showStudentLoginForm')->name('web.student.login');
        Route::get('/register', 'registerStudent')->name('web.student.register');
        Route::post('/register', 'storeStudent')->name('process.student.register');
        Route::get('/activate', 'showAccountActivateForm')->name('student.activate');
        Route::post('/activate', 'processAccountActivate')->name('student.activate.account');
    });

    Route::controller(StudentLoginController::class)->group(function () {
        Route::post('/login', 'authenticate')->name('process.student.login');
    });

    Route::middleware(['auth:student', 'is_account_activated'])->group(function() {
        Route::controller(StudentController::class)->group(function () {
            Route::get('/dashboard', 'dashboard')->name('student.dashboard');
            Route::post('/logout', 'logout')->name('student.logout');
            Route::post('/transcript-requests', 'processTranscriptRequest' )->name('student.transcript.request');
            Route::post('/transcript-requests/{id}', 'updateTranscriptRequest' )->name('student.transcript.request.update');
            Route::get('/transcript-requests/{id}', 'showTranscriptRequest' )->name('student.transcript.request.show');
            Route::get('/users/change-password', 'showStudentChangePasswordForm' )->name('student.change.password');
            Route::post('/users/password/reset', 'processStudentChangePasswordForm')->name('student.users.process.change.password');
            Route::get('/users/profile', 'showStudentProfile' )->name('student.users.profile');
            Route::get('/edit/profile', 'editStudentProfile' )->name('student.profile.edit');
            Route::post('/update/profile', 'updateStudentProfile' )->name('student.profile.update');

        });
    });
});

Route::prefix('enquirers')->group(function() {

    Route::controller(EnquirerController::class)->group(function () {
        Route::get('/login', 'showLoginForm')->name('web.verify.result.login');
        Route::get('/register', 'register')->name('verify.result.register');
        Route::post('/register', 'store')->name('process.verify.result.register');
        Route::get('/activate', 'showAccountActivateForm')->name('verify.result.activate');
        Route::post('/activate', 'processAccountActivate')->name('verify.result.activate.account');
    });

    Route::controller(EnquirerController::class)->group(function () {
        Route::post('/login', 'authenticate')->name('process.verify.result.login');
    });

    Route::middleware(['auth:result-verifier', 'is_result_verifier_profile_updated'])->group(function() {
        Route::controller(EnquirerController::class)->group(function () {
            Route::get('/dashboard', 'index')->name('verify.result.dashboard');
            Route::post('/logout', 'logout')->name('verify.result.logout');
            Route::get('/edit/profile', 'editResultVerifierProfile' )->name('verify.result.profile.edit');
            Route::post('/update/profile', 'updateResultVerifierProfile' )->name('verify.result.profile.update');
            Route::post('/requests', 'processVerifyResultRequest' )->name('verify.result.requests');
            Route::get('/requests/{id}', 'showVerifyResultRequest' )->name('verify.result.requests.show');
            Route::post('/requests/{id}', 'updateVerifyResultRequest' )->name('verify.result.requests.update');
            Route::get('/payments', 'listAllVerifyResultPayments' )->name('verify.result.payments.list');
            Route::post('/payment', 'handleVerifyResultPayment' )->name('verify.result.payment');
            Route::get('/fees/{name}', 'getTranscriptFee')->name('verify.result.get.fee');
            Route::get('/users/profile', 'showResultVerifierProfile' )->name('verify.result.users.profile');
            Route::get('/users/change-password', 'showResultVerifierChangePasswordForm' )->name('verify.result.change.password');
            Route::post('/users/password/reset', 'processResultVerifierChangePasswordForm')->name('verify.resultusers.process.change.password');
            Route::get('/users/student/password-reset','studentFirstLogin')->name('verify.result.password-reset');
            Route::post('/users/student/password-reset','firstLoginResetPassword')->name('verify.result.process.password-reset');
        });
    });
});

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
            Route::get('/students/login/{id}', 'viewStudent')->name('web.users.show');
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
            Route::get('/transcript-requests', 'index')->name('list.transcript-requests');
        });

        Route::controller(ResultVerificationRequestController::class)->group(function () {
            Route::get('/verification-requests', 'index')->name('verification-requests');
        });

        Route::controller(GradeController::class)->group(function () {
            Route::get('/grades', 'index')->name('grades');
        });

    });
});
