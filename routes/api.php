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
Route::get('characters', 'CharacterController@getStandard');
Route::get('characters/{id}', 'CharacterController@getById');
Route::post('characters', 'CharacterController@create');
Route::put('characters/{id}', 'CharacterController@update');
Route::delete('characters/{id}', 'CharacterController@delete');
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
