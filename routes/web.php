<?php

use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;
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
    //return view('welcome');
	return view('main');
})->name('home');

Route::post('/main', [FormController::class, 'processForm'])->name('form.process');

Route::get('/teacher', [TeacherController::class, 'show'])
    ->middleware('is_teacher');

Route::get('/student', [StudentController::class, 'show'])
    ->middleware('is_student');

Route::get('/login', [UserController::class, 'login'])
    ->middleware('guest');

Route::post('/users/authenticate', [UserController::class, 'authenticate']);

Route::post('/logout', [UserController::class, 'logout'])
    ->middleware('auth');
