<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::resource('categories', 'Categories\CategoryController');
Route::resource('products', 'Products\ProductController');
Route::resource('addresses', 'Addresses\AddressController');
Route::resource('countries', 'Countries\CountryController');
Route::resource('orders', 'Orders\OrderController');

Route::get('addresses/{address}/shipping', 'Addresses\AddressShippingController@action');


Route::resource('cart', 'Cart\CartController', [
    'parameters' => [
        'cart' => 'productVariation'
    ]
]);

Route::group(['prefix' => 'auth'], function() {
    Route::post('register', 'Auth\RegisterController@action');
    Route::post('login', 'Auth\LoginController@action');
    Route::get('me', 'Auth\MeController@action');
});
