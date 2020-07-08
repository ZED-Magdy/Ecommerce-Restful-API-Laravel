<?php

use Illuminate\Support\Facades\Route;

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refreshToken');
    Route::post('me', 'AuthController@authUser');
});

Route::resource('users', 'UserController');
Route::resource('categories','CategoryController')->only(['index','show']);

Route::group(['prefix' => 'products'], function () {
    Route::get('/','ProductController@index')->name('products.index');
    Route::get('/{product}','ProductController@show')->name('products.show');
    Route::patch('/{product}','ProductController@update')->name('products.update');
    Route::delete('/{product}','ProductController@destroy')->name('products.destroy');
    Route::post('/','ProductController@store')->name('products.store')->middleware('auth:api');
    Route::get('/{product}/ratings','ProductRateController@index')->name('product.ratings.index');
    Route::post('/{product}/ratings','ProductRateController@store')->name('product.ratings.store')->middleware('auth:api');
});
Route::get('/search','SearchController@search');