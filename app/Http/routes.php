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
Route::get('/','PersonController@index'); //temporalmente
Route::get('home', 'HomeController@index');
Route::get('person/{id}/interaction/create','InteractionController@create');
Route::post('person/{id}/interaction','InteractionController@store');
Route::get('person/showAllFrom/{id}','PersonController@showAllFrom');
Route::get('user/search','UserController@search');
Route::get('user/{id}','UserController@home');
Route::get('user/edit/{id}','UserController@edit');
Route::get('user/show/{id}','UserController@show');
Route::get('user/searchView/{id}','UserController@searchView');
Route::resource('person','PersonController');
Route::resource('interaction','InteractionController');
Route::resource('needsArea','NeedsAreaController');
Route::resource('user','UserController');


//Route::get('needsArea/edit/{id}','NeedsAreaController@edit');

//Route::get('person/edit/{id}','PersonController@edit');
//Route::get('interaction/edit/{id}','InteractionController@edit');
//Route::get('interaction/create/{id}','InteractionController@create');




Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
