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

Route::get('api/products/category/{id}', 'MagentoApiController@getProductsByCategoryId');
Route::get('/api/categories',  'MagentoApiController@getAllCategories');
Route::get('/api/categoryNames',  'MagentoApiController@getCategoryNames');
/* get the list for the drop down */
Route::get('/api/categorylist',  'MagentoApiController@getCategoryList');



// get-started

// get-started/step/1
// get-started/step/2
// get-started/step/3

// get-started/step/4
// get-started/thanks
// get-started/send



// contact-us

//

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
