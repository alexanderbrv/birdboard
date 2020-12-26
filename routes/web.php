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

Route::view('/', 'welcome');

Route::group(['middleware' => 'auth'], function () {
    Route::resource('/projects', 'ProjectsController');
    Route::post('/projects/{project}/tasks', 'TasksController@store')->name('tasks.store');
    Route::patch('/projects/{project}/tasks/{task}', 'TasksController@update')->name('tasks.update');
    Route::get('/home', 'HomeController@index')->name('home');
});

Auth::routes();
