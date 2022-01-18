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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('login', 'AuthController@login');
Route::post('register', 'AuthController@register');

Route::group(['middleware' => 'auth:api'], function(){
    Route::post('logout', 'AuthController@logout');
});

Route::get('/products', 'ProductsController@index');
Route::post('/products', 'ProductsController@store')->middleware('auth:api');
Route::get('/product/{id}', 'ProductsController@show');
Route::patch('/product/{id}', 'ProductsController@update');
// Route::post('/products', 'ProductsController@store')->middleware('auth:api');
Route::delete('/product/{id}', 'ProductsController@destroy')->middleware('auth:api');
