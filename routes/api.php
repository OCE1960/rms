<?php

use App\Http\Controllers\AcademicResultController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\ResultVerificationRequestController;
use App\Http\Controllers\SchoolController;
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
        Route::post('/semesters', 'processAddSemester')->name('semesters');
        Route::get('/semesters/{id}', 'show')->name('semesters.show');
        Route::post('/semesters/{id}', 'update')->name('semesters.update');
        Route::post('/semesters/delete/{id}', 'destroy')->name('semesters.delete');
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
        Route::post('/semester-results', 'processAddSemesterResult')->name('semester.results');
        Route::get('/semester-results/{id}', 'show')->name('semester.results.show');
        Route::post('/semester-results/{id}', 'update')->name('semester.results.update');
        Route::post('/semester-results/delete/{id}', 'destroy')->name('semester.results.delete');
    });

    Route::controller(SchoolController::class)->group(function () {
        Route::get('/schools/{id}', 'show')->name('schools.show');
        Route::post('/schools', 'store')->name('schools.store');
        Route::post('/schools/{id}', 'update')->name('schools.update');
        Route::post('/schools/delete/{id}', 'destroy')->name('schools.delete');
    });
});
