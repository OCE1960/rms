<?php

use App\Http\Controllers\AcademicResultController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\ResultVerificationRequestController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\TaskAssignmentController;
use App\Http\Controllers\TranscriptRequestController;
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
        Route::post('/users/reset/{id}', 'resetPassword')->name('users.password.reset');
        Route::post('/users/students/bulk-upload', 'processStudentBulkUpload')->name('users.students.bulk.upload');
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
        Route::post('/move-file', 'processMoveFile')->name('move-file');
    });

    Route::controller(SemesterController::class)->group(function () {
        Route::post('/semesters', 'processAddSemester')->name('semesters.store');
        Route::get('/semesters/{id}', 'show')->name('semesters.show');
        Route::post('/semesters/{id}', 'update')->name('semesters.update');
        Route::post('/semesters/delete/{id}', 'destroy')->name('semesters.delete');
        Route::post('/semesters/csv/bulk-upload', 'processSemesterBulkUpload')->name('semesters.bulk.upload');
    });

    Route::controller(TranscriptRequestController::class)->group(function () {
        Route::get('/transcript-requests/{id}', 'show')->name('transcript-request.show');
        Route::post('/assign-transcript-requests-file', 'assignTranscriptRequestFile')->name('assign-transcript-requests-file');
    });

    Route::controller(ResultVerificationRequestController::class)->group(function () {
        Route::get('/verification-requests/{id}', 'show')->name('verification-request.show');
        Route::post('/assign-verification-requests-file', 'assignVerificationRequestFile')->name('assign-verification-requests-file');
    });

    Route::controller(GradeController::class)->group(function () {
        Route::get('/grading-systems', 'index')->name('grading-systems');
        Route::post('/grading-systems/store', 'store')->name('grading-systems.store');
        Route::get('/grading-systems/show/{id}', 'show')->name('grading-systems.show');
        Route::post('/grading-systems/update/{id}', 'update')->name('grading-systems.update');
        Route::get('/grading-systems/view-details/{id}', 'viewDetails')->name('grading-systems.view.details');
    });

    Route::controller(AcademicResultController::class)->group(function () {
        Route::post('/academic-results', 'processAddSemesterResult')->name('academic.results');
        Route::get('/academic-results/{id}', 'show')->name('academic.results.show');
        Route::post('/academic-results/{id}', 'update')->name('academic.results.update');
        Route::post('/academic-results/delete/{id}', 'destroy')->name('academic.results.delete');
        Route::post('/academic-results/csv/bulk-upload', 'processAcademicResultBulkUpload')->name('academic.results.bulk.upload');
    });

    Route::controller(SchoolController::class)->group(function () {
        Route::get('/schools/{id}', 'show')->name('schools.show');
        Route::post('/schools', 'store')->name('schools.store');
        Route::post('/schools/{id}', 'update')->name('schools.update');
        Route::post('/schools/delete/{id}', 'destroy')->name('schools.delete');
    });

    Route::controller(StudentController::class)->group(function () {
        Route::get('/students/{id}', 'show')->name('students.show');
        Route::post('/students', 'store')->name('students.store');
        Route::post('/students/{id}', 'update')->name('students.update');
        Route::post('/students/delete/{id}', 'destroy')->name('students.delete');
    });

    Route::controller(CoursesController::class)->group(function () {
        Route::get('/courses/{id}', 'show')->name('courses.show');
        Route::post('/courses', 'store')->name('courses.store');
        Route::post('/courses/{id}', 'update')->name('courses.update');
        Route::post('/courses/delete/{id}', 'destroy')->name('courses.delete');
        Route::post('/courses/csv/bulk-upload', 'processCourseBulkUpload')->name('courses.bulk.upload');
    });

    Route::controller(StaffController::class)->group(function () {
        Route::get('/staffs/{id}', 'show')->name('staffs.show');
        Route::post('/staffs', 'store')->name('staffs.store');
        Route::post('/staffs/{id}', 'update')->name('staffs.update');
        Route::post('/staffs/delete/{id}', 'destroy')->name('staffs.delete');
    });
});
