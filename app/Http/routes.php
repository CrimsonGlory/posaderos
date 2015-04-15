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

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');
Route::get('needsArea/edit/{id}','NeedsAreaController@edit');
Route::get('user/edit/{id}','UserController@edit');
Route::get('person/edit/{id}','PersonController@edit');
Route::get('interaction/edit/{id}','InteractionController@edit');
Route::get('interaction/create/{id}','InteractionController@create');
Route::get('person/showAllFrom/{id}','PersonController@showAllFrom');


Route::resource('person','PersonController');


Route::resource('needsArea','NeedsAreaController');
Route::resource('user','UserController');
Route::resource('interaction','InteractionController');



Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
