<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::resource('categories', 'Categories\CategoryController');
Route::resource('products', 'Products\ProductController');
Route::resource('cart', 'Cart\CartController');

Route::group(['prefix' => 'auth'], function() {
    Route::post('register', 'Auth\RegisterController@action');
    Route::post('login', 'Auth\LoginController@action');
    Route::get('me', 'Auth\MeController@action');
});
