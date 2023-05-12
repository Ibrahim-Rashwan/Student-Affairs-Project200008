<?php

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

<<<<<<< HEAD
Route::get('/user ', function () {
    return 'first commit';
=======
Route::get('/sayed', function () {
    return view('welcome');
>>>>>>> 9685409b689be8a553e286fe1e9ec3498f93d214
});
