<?php

use Illuminate\Http\Request;

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

Route::group(['prefix' => '/auth', 'middleware' => 'api'], function(){
	Route::post('/login', 'Api\AuthController@login');
	Route::post('/register', 'Api\AuthController@register');
	Route::post('/password', 'Api\AuthController@password');
	Route::post('/password/reset', 'Api\AuthController@passwordReset');

	Route::group(['middleware' => ['jwtauth']], function(){
		Route::get('/me', 'Api\AuthController@me');
		Route::get('/logout', 'Api\AuthController@logout');
		Route::get('/refresh', 'Api\AuthController@refresh');
	});

	Route::get('/verify/{token}', 'Api\AuthController@verifyEmail');
});

Route::group(['prefix' => '/calculator', 'middleware' => ['jwtauth']], function(){
// Route::group(['prefix' => '/calculator', 'middleware' => ['jwt.refresh']], function(){
	Route::get('/index', 'Api\CalculatorController@index');
	Route::post('/add', 'Api\CalculatorController@add');
	Route::post('/delete', 'Api\CalculatorController@delete');
	Route::post('/statistics', 'Api\CalculatorController@statistics');
});

