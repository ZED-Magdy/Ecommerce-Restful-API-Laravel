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

Route::resource('products','ProductController')->except('store');
Route::post('products','ProductController@store')->middleware('auth:api');
Route::resource('categories','CategoryController')->only(['index','show']);