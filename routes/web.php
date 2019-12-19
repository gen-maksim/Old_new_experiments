<?php

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

Route::get('/', 'HomeController@welcome');

Auth::routes();


Route::resource('trainings', 'TrainingController');

Route::get('/profile/{user}', 'UserController@profile')->name('user.profile');
Route::get('/profile/{user}', 'UserController@trainings')->name('user.trainings');

Route::get('/home', 'HomeController@index')->name('home');
