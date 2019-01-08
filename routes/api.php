<?php

Route::resource('categories', 'Categories\CategoryController');
Route::resource('products', 'Products\ProductController');

Route::prefix('auth')->namespace('Auth')->group(function () {
    Route::post('register', 'RegisterController@action');
    Route::post('login', 'LoginController@action');
    Route::get('me', 'MeController@action');
});
