<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::get('notes', 'App\Http\Controllers\NotesController@index');
Route::get('notes/{id}', 'App\Http\Controllers\NotesController@show');
Route::post('notes', 'App\Http\Controllers\NotesController@store');
Route::put('notes/{id}', 'App\Http\Controllers\NotesController@update');
Route::delete('notes/{id}', 'App\Http\Controllers\NotesController@delete');
Route::get('tags', 'App\Http\Controllers\TagsController@index');
Route::get('tags/{id}', 'App\Http\Controllers\TagsController@show');
Route::post('tags', 'App\Http\Controllers\TagsController@store');
Route::put('tags/{id}', 'App\Http\Controllers\TagsController@update');
Route::delete('tags/{id}', 'App\Http\Controllers\TagsController@delete');
