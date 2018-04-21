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

Route::group(['prefix' => '/auth'], function(){
	Route::post('/login', 'Api\AuthController@login');
	Route::post('/register', 'Api\AuthController@register');
	Route::post('/password', 'Api\AuthController@password');
	Route::post('/password/reset', 'Api\AuthController@passwordReset');

	Route::group(['middleware' => 'jwt.auth'], function(){
		Route::get('/me', 'AuthController@me');
		Route::get('/logout', 'AuthController@logout');
		Route::get('/refresh', 'AuthController@refresh');
	});
});