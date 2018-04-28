<?php

require_once(app_path('Helpers/Input.php'));

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
	// return view('home');
    return redirect('/admin/foods');
});

// Route::get('/home', function () {
// 	return view('home');
// });

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin'], function() {

	Route::resource('users', 'Admin\UserController')->except(['create', 'store']);
	Route::resource('foods', 'Admin\FoodController');


	Route::get('/lohere', function(){
		dd(Auth::user());
	});
});

