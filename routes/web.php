<?php

use App\Http\Controllers\CoursesController;
use App\Http\Controllers\ExamsController;
use App\Http\Controllers\MaterialsController;
use App\Http\Controllers\DepartmentsController;
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

Route::get('/t', [CoursesController::class, 't']);
Route::post('/tt', [CoursesController::class, 'tt']);

Route::resource('departments', DepartmentsController::class);
Route::resource('courses', CoursesController::class);
Route::resource('courses.materials', MaterialsController::class)->except(['index', 'show']);
Route::resource('courses.exams', ExamsController::class)->except(['index', 'show']);
// Route::resource('courses.materials', CoursesController::class)->only(['create', 'store']);

