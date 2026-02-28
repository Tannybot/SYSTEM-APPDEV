<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\FacultyController;

/* |-------------------------------------------------------------------------- | Web Routes |-------------------------------------------------------------------------- | | Here is where you can register web routes for your application. These | routes are loaded by the RouteServiceProvider within a group which | contains the "web" middleware group. Now create something great! | */

Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::get('/login', [AuthController::class , 'showLogin'])->name('login');
Route::post('/login', [AuthController::class , 'authenticate']);
Route::get('/signup', [AuthController::class , 'showSignup'])->name('signup');
Route::post('/signup/role', [AuthController::class , 'processSignupRole']);
// Role specific signup routes
Route::get('/signup/student', [AuthController::class , 'showStudentSignup'])->name('signup.student');
Route::post('/signup/student', [AuthController::class , 'registerStudent']);
Route::get('/signup/faculty', [AuthController::class , 'showFacultySignup'])->name('signup.faculty');
Route::post('/signup/faculty', [AuthController::class , 'registerFaculty']);

Route::post('/logout', [AuthController::class , 'logout'])->name('logout');

// Student Routes
Route::prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentController::class , 'dashboard'])->name('dashboard');
    Route::get('/faculty', [StudentController::class , 'faculty'])->name('faculty');
    Route::post('/faculty', [StudentController::class , 'faculty']);
    Route::get('/schedule', [StudentController::class , 'schedule'])->name('schedule');
    Route::post('/schedule', [StudentController::class , 'schedule']);
    Route::post('/schedule/add', [StudentController::class , 'addSession'])->name('schedule.add');
    Route::get('/appointment', [StudentController::class , 'appointment'])->name('appointment');
    Route::post('/appointment', [StudentController::class , 'appointment']);
    Route::get('/settings', [StudentController::class , 'settings'])->name('settings');
    Route::post('/settings', [StudentController::class , 'settings']);
    Route::post('/settings/edit', [StudentController::class , 'editStudent'])->name('settings.edit');
    Route::post('/settings/delete', [StudentController::class , 'deleteAccount'])->name('settings.delete');
});

// Faculty Routes
Route::prefix('faculty')->name('faculty.')->group(function () {
    Route::get('/dashboard', [FacultyController::class , 'dashboard'])->name('dashboard');
    Route::get('/appointment', [FacultyController::class , 'appointment'])->name('appointment');
    Route::get('/appointment/done', [FacultyController::class , 'markDone'])->name('appointment.done');
    Route::post('/appointment/delete', [FacultyController::class , 'deleteAppointment'])->name('appointment.delete');
    Route::post('/submit-review', [FacultyController::class , 'submitReview'])->name('submit-review');
    Route::get('/schedule', [FacultyController::class , 'schedule'])->name('schedule');
    Route::post('/schedule', [FacultyController::class , 'schedule']);
    Route::post('/schedule/delete', [FacultyController::class , 'deleteSession'])->name('schedule.delete');
    Route::get('/student', [FacultyController::class , 'student'])->name('student');
    Route::get('/settings', [FacultyController::class , 'settings'])->name('settings');
    Route::post('/settings', [FacultyController::class , 'settings']);
    Route::post('/settings/edit', [FacultyController::class , 'editFaculty'])->name('settings.edit');
    Route::post('/settings/delete', [FacultyController::class , 'deleteAccount'])->name('settings.delete');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\AdminController::class , 'dashboard'])->name('dashboard');
    Route::get('/faculty', [\App\Http\Controllers\AdminController::class , 'faculty'])->name('faculty');
    Route::post('/faculty', [\App\Http\Controllers\AdminController::class , 'faculty']);
    Route::post('/faculty/add', [\App\Http\Controllers\AdminController::class , 'addFaculty'])->name('faculty.add');
    Route::post('/faculty/edit', [\App\Http\Controllers\AdminController::class , 'editFaculty'])->name('faculty.edit');
    Route::post('/faculty/delete', [\App\Http\Controllers\AdminController::class , 'deleteFaculty'])->name('faculty.delete');

    Route::get('/schedule', [\App\Http\Controllers\AdminController::class , 'schedule'])->name('schedule');
    Route::post('/schedule', [\App\Http\Controllers\AdminController::class , 'schedule']);
    Route::post('/schedule/delete', [\App\Http\Controllers\AdminController::class , 'deleteSession'])->name('schedule.delete');

    Route::get('/appointment', [\App\Http\Controllers\AdminController::class , 'appointment'])->name('appointment');
    Route::post('/appointment', [\App\Http\Controllers\AdminController::class , 'appointment']);
    Route::post('/appointment/delete', [\App\Http\Controllers\AdminController::class , 'deleteAppointment'])->name('appointment.delete');

    Route::get('/student', [\App\Http\Controllers\AdminController::class , 'student'])->name('student');
    Route::post('/student', [\App\Http\Controllers\AdminController::class , 'student']);

    Route::get('/settings', [\App\Http\Controllers\AdminController::class , 'settings'])->name('settings');
});
