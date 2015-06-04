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

Route::get('/',                                 'HomeController@index');
Route::get('home',                              'HomeController@index');
Route::get('person/{id}/interaction/create',    'InteractionController@create');
Route::post('person/{id}/interaction',          'InteractionController@store');
Route::post('person/{id}/addFavorite',          'PersonController@addFavorite');
Route::post('person/{id}/removeFavorite',       'PersonController@removeFavorite');
Route::get('person/{id}/fileentries/photos',    'FileEntryController@create');
Route::get('person/{id}/photos',                'PersonController@photos');
Route::post('person/{id}/setavatar',            'PersonController@setAvatar');
Route::post('person/{id}/fileentries',          'FileEntryController@store');
Route::get('search/search',                     'SearchController@search');
Route::get('search/searchView',                 'SearchController@searchView');
Route::resource('person',                       'PersonController');
Route::resource('interaction',                  'InteractionController');
Route::get('user/{id}/favorites',               'UserController@favorites');
Route::get('user/{id}/derivations',             'UserController@derivations');
Route::resource('user',                         'UserController');
Route::get('tag',                               'TagController@index');
Route::get('tag/{name}',                        'TagController@show');
Route::get('file/{id}',                         'FileEntryController@show');
Route::get('photo/{size}/{id}',                 'FileEntryController@showThumb');
Route::get('photo/{id}',                        'FileEntryController@show');
Route::get('report/peopleList',                 'ReportController@peopleList');
Route::get('report/interactionsList',           'ReportController@interactionsList');
Route::post('report/downloadPeopleList',        'ReportController@downloadPeopleList');
Route::post('report/downloadInteractionsList',  'ReportController@downloadInteractionsList');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

