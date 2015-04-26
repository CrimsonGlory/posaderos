<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//Route::get('/', 'WelcomeController@index');
Route::get('/','HomeController@index');
Route::get('home', 'HomeController@index');
Route::get('person/{id}/interaction/create','InteractionController@create');
Route::post('person/{id}/interaction','InteractionController@store');
Route::get('user/search','UserController@search');
Route::get('user/searchView/{id}','UserController@searchView');
Route::resource('person','PersonController');
Route::resource('interaction','InteractionController');
Route::resource('user','UserController');
Route::get('tag','TagController@index');
Route::get('tag/{name}','TagController@show');



Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
