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

Route::post('/main', [FormController::class, 'processForm'])
    ->name('form.process');

Route::get('/teacher', [TeacherController::class, 'index'])
    ->middleware('is_teacher');

Route::get('/student', [StudentController::class, 'show'])
    ->middleware('is_student');

Route::get('/login', [UserController::class, 'login'])
    ->middleware('guest');

Route::get('/guideStudent',[StudentController::class,'guide'])
    ->name('guideStudent')
    ->middleware('is_student');

Route::get('/guideTeacher',[TeacherController::class,'guide'])
    ->name('guideTeacher')
    ->middleware('is_teacher');

Route::post('/users/authenticate', [UserController::class, 'authenticate']);

Route::post('/logout', [UserController::class, 'logout'])
    ->middleware('auth');

Route::post('/file/edit/{name}', [TeacherController::class, 'edit'])
    ->name('file.edit')
    ->middleware('is_teacher');

Route::get('/table', [TeacherController::class, 'table'])
    ->name('teacher.table')
    ->middleware('is_teacher');

Route::get('/table/{user}', [TeacherController::class, 'studentTable'])
    ->name('teacher.studentTable')
    ->middleware('is_teacher');


//TODO: zmenit niektore metody na post
Route::get('student/generateNewTask',[StudentController::class,'generateNewTask'])
    ->middleware('is_student');
Route::get('student/showTasks',[StudentController::class,'showTasks'])
    ->middleware('is_student');
Route::get('student/showTask/{id}',[StudentController::class,'showTask'])
    ->middleware('is_student');

Route::post('student/submitTask/{id}',[StudentController::class,'submitTask'])
    ->middleware('is_student');

Route::post('/generate-csv',[FormController::class, 'generateCSV'])
    ->name('generate.csv');
Route::post('/generateMain-csv',[FormController::class, 'generateMainCSV'])
    ->name('generate.main.csv');






