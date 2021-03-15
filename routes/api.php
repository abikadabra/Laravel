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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('login','loginController@index');
Route::post('login','loginController@login');
Route::post('register','loginController@register');
Route::get('allUser','loginController@index');


Route::get('edit','loginController@edit');
Route::post('update/{id}','loginController@update');

Route::post('delete/{id}','loginController@delete');
Route::get('logout','loginController@logout');