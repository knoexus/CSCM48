<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/user/{id}', 'App\Http\Controllers\UserController@show')->name('user.show');

Route::get('/user/{id}/edit', 'App\Http\Controllers\UserController@edit')->name('user.edit')->middleware('auth');

Route::post('/user/{id}', 'App\Http\Controllers\UserController@update')->name('user.update')->middleware('auth');

Route::get('/user/{id}/journey/create', 'App\Http\Controllers\JourneyController@create')->name('journey.create')->middleware('auth');

Route::post('/user/{id}/journey/create', 'App\Http\Controllers\JourneyController@create')->name('journey.create')->middleware('auth');

Route::get('/user/{id}/journey/{journey_id}', 'App\Http\Controllers\JourneyController@show')->name('journey.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
