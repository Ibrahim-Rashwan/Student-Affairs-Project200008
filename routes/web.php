<?php

use App\Http\Controllers\CoursesController;
use App\Http\Controllers\ExamsController;
use App\Http\Controllers\MaterialsController;
use App\Http\Controllers\DepartmentsController;
use App\Http\Controllers\DoctorsController;
use App\Http\Controllers\StudentsController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/courses/{course}/materials/create', [CoursesController::class, 'create_material']);
// Route::post('/courses/{course}/materials', [CoursesController::class, 'store_material']);
// Route::delete('/courses/{course}/materials/{material}', [CoursesController::class, 'destroy_material']);

// Route::get('/t', [CoursesController::class, 't']);
// Route::post('/tt', [CoursesController::class, 'tt']);

Route::resource('departments', DepartmentsController::class);

Route::resource('courses', CoursesController::class);
Route::resource('courses.materials', MaterialsController::class)->except(['index', 'show']);
Route::resource('courses.exams', ExamsController::class)->except(['index', 'show']);
Route::post('courses/{course}/subscribe', [CoursesController::class, 'subscribe']);
Route::post('courses/{course}/generate_student_names', [CoursesController::class, 'generate_student_names']);

Route::resource('doctors', DoctorsController::class);

Route::resource('students', StudentsController::class);
// Route::resource('courses.materials', CoursesController::class)->only(['create', 'store']);


Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

