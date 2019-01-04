<?php

use App\Http\Controllers\GraphController;

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
Route::get('/graphline', 'GraphController@index');
Route::get('/graphline/data', 'GraphController@graph');
Route::get('/', function () {
    return view('welcome');
});
