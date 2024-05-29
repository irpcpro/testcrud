<?php

use Illuminate\Support\Facades\Route;


Route::prefix('v1')->namespace('V1')->group(function () {

    // authentication
    Route::prefix('auth')->namespace('Auth')->group(function () {
        Route::post('/register', 'AuthRegisterAPIController@register');
        Route::post('/login', 'AuthLoginAPIController@login');
    });

    // private routes
    Route::prefix('product')->middleware('auth:api')->namespace('Product')->group(function(){
        Route::get('/', 'ProductAPIController@index');
        Route::post('/store', 'ProductStoreAPIController@store');
        Route::put('/{product}', 'ProductUpdateAPIController@update');
        Route::get('/{product}', 'ProductShowAPIController@show');
        Route::delete('/{product}', 'ProductDeleteAPIController@delete');
    });

});
