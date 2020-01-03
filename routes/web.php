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

Route::get('/', 'TrainingController@index');

Auth::routes();


Route::resource('trainings', 'TrainingController');

Route::get('/profile/{user}', 'UserController@profile')->name('user.profile');
Route::get('/profile/{user}/trainings', 'UserController@trainings')->name('user.trainings');

Route::post('/training_applications/store', 'TrainingApplicationController@store')->name('training_applications.store');
//Route::get('/training_applications/create', 'TrainingApplicationController@create')->name('training_applications.create'); //might need it in future