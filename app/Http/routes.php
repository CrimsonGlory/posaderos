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
Route::get('person/{id}/fileentries/photos','FileEntryController@index');
Route::post('person/{id}/fileentries','FileEntryController@add');
Route::resource('person','PersonController');
Route::resource('interaction','InteractionController');
Route::resource('needsArea','NeedsAreaController');
Route::resource('user','UserController');
Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

