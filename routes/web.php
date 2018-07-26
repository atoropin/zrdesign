<?php

/**
 * Car info get methods
 */

//Route::get('/', 'CarController@index');
//Route::get('/body/{id}', 'CarController@carBody');


Route::get('/', 'HomeController@index');

//Route::prefix('products')->group(function () {
//    Route::get('manufacturer/{manufacturer}', ['as' => 'manufacturer', 'uses' => 'HomeController@getProducts']);
//    Route::get('group/{group}', ['as' => 'group', 'uses' => 'HomeController@getProducts']);
//    Route::get('body/{body}', ['as' => 'body', 'uses' => 'HomeController@getProducts']);
//});

//Route::get('/products', ['as' => 'products', 'uses' => 'HomeController@getProducts']);
Route::get('/products', ['as' => 'products', 'uses' => 'HomeController@products']);

Route::get('/body', ['as' => 'body', 'uses' => 'HomeController@getBodyProducts']);

Route::get('/test', 'HomeController@test');

//Route::get('/img/{id}/{size}/{name}', 'HomeController@getImage');
Route::get('/img/{id}/{size}/{name}', 'HomeController@showImage');


//Route::get('products/manufacturer/{manufacturer?}', 'HomeController@getProducts');
//Route::get('products/group/{group?}', 'HomeController@getProducts');

//Route::get('products/{manufacturer?}/{group?}/{body?}', 'HomeController@getBodyProducts');


/**
 * Shopping Cart methods
 */

Route::get('/cart/view', 'CartController@viewCart');
Route::post('/cart/add/{product}', 'CartController@addToCart');
Route::get('/cart/delete/{item}', 'CartController@deleteFromCart');
Route::post('/cart/send',  'CartController@sendOrder');