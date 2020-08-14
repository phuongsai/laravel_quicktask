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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// CRUD Task
Route::get('/task', [
    'uses' => 'TaskController@index',
    'as' => 'task.index',
    'middleware' => 'auth',
]);

// JSON response
Route::group(['prefix' => 'api/task', 'as' => 'task.', 'middleware' => 'auth'], function () {
    Route::post('/store', [
        'uses' => 'TaskController@store',
        'as' => 'store',
    ]);

    Route::get('/edit/{task}', [
        'uses' => 'TaskController@edit',
        'as' => 'edit',
    ]);

    Route::delete('/delete/{task}', [
        'uses' => 'TaskController@destroy',
        'as' => 'delete',
    ]);

    Route::delete('/forceDelete/{task}', [
        'uses' => 'TaskController@forceDelete',
        'as' => 'forceDelete',
    ]);

    Route::patch('/restoreTrash/{task}', [
        'uses' => 'TaskController@restoreTrash',
        'as' => 'restoreTrash',
    ]);

    Route::get('/trash', [
        'uses' => 'TaskController@getTrashRecords',
        'as' => 'trash',
    ]);
});