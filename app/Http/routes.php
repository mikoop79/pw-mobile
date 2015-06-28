<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
Route::get('get-started', 'HomeController@index');
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/',  'HomeController@index');

//Route::get('api/category{$id}/', 'MagentoApiController@getProductsByCategory');

Route::get('/api/categories',  'MagentoApiController@getCategoryNames');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

//Route::get('/api/category/{$id}', 'MagentoApiController@getProductsByCategory');
Route::get('/api/category/{$cid}' , array('as' => 'api.category', 'uses' => 'MagentoApiController@getProductsByCategory'));