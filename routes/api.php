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

Route::post('register', 'Api\UserController@register');
Route::post('login', 'Api\UserController@login');
//Route::get('book', 'Api\BookController@book');

Route::get('bookall', 'Api\BookController@bookAuth')->middleware('jwt.verify');
Route::get('user', 'Api\UserController@getAuthenticatedUser')->middleware('jwt.verify');

Route::apiResource('books', 'Api\BookController')->middleware('jwt.verify');
Route::get('book/{create_by}', 'Api\BookController@index')->middleware('jwt.verify');
