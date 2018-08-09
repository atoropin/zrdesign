<?php

/**
 * Main Page
 */
Route::get('/', 'HomeController@index');

/**
 * Products
 */
Route::get('/products', ['as' => 'products', 'uses' => 'HomeController@products']);

/**
 * Shopping Cart
 */
Route::get('/cart', 'CartController@viewCart');
Route::post('/cart/add/{product}', 'CartController@addToCart');
Route::post('/cart/delete/{item}', 'CartController@deleteFromCart');
Route::post('/cart/send',  'CartController@sendOrder');