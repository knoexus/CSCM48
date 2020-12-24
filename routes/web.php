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

Route::get('/users/{id}', 'App\Http\Controllers\UserController@show')->name('users.show');
Route::get('/users/{id}/edit', 'App\Http\Controllers\UserController@edit')->name('users.edit')->middleware('auth');
Route::post('/users/{id}', 'App\Http\Controllers\UserController@update')->name('users.update')->middleware('auth');

Route::get('/users/{id}/journeys/create', 'App\Http\Controllers\JourneyController@create')->name('journeys.create')->middleware('auth');
Route::post('/users/{id}/journeys/create', 'App\Http\Controllers\JourneyController@create')->name('journeys.create')->middleware('auth');
Route::get('/users/{id}/journeys/{journey_id}/edit', 'App\Http\Controllers\JourneyController@edit')->name('journeys.edit')->middleware('auth');
Route::put('/users/{id}/journeys/{journey_id}', 'App\Http\Controllers\JourneyController@update')->name('journeys.update')->middleware('auth');
Route::get('/users/{id}/journeys/{journey_id}', 'App\Http\Controllers\JourneyController@show')->name('journeys.show');

Route::post('/users/{id}/journeys/{journey_id}/comments/create', 'App\Http\Controllers\CommentController@create')->name('comments.create')->middleware('auth');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
