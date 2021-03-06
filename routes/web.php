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

Route::get('/', function () {
    $projects = \App\Project::where('active', true)
        ->orderBy('id', 'desc')
        ->get();
    return view('welcome')->with(['projects' => $projects]);
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// projects
Route::resource('projects', 'ProjectsController');

// users
Route::resource('users', 'UsersController');