<?php

use Illuminate\Support\Facades\Route;


Route::prefix('v1')->namespace('V1')->group(function () {

    // authentication
    Route::prefix('auth')->namespace('Auth')->group(function () {
        Route::post('/register', 'AuthRegisterAPIController@register');
        Route::post('/login', 'AuthLoginAPIController@login');
    });

    // private routes
    Route::middleware('auth:api')->group(function(){
        // product
        Route::prefix('product')->namespace('Product')->group(function(){
            Route::get('/', 'ProductAPIController@index');
            Route::post('/store', 'ProductStoreAPIController@store');
            Route::put('/{product}', 'ProductUpdateAPIController@update');
            Route::get('/{product}', 'ProductShowAPIController@show');
            Route::delete('/{product}', 'ProductDeleteAPIController@delete');
        });

        // order
        Route::prefix('order')->namespace('Order')->group(function(){
            Route::get('/', 'OrderAPIController@index');
            Route::post('/store', 'OrderStoreAPIController@store');
            Route::put('/{order}', 'OrderUpdateAPIController@update');
            Route::get('/{order}', 'OrderShowAPIController@show');
            Route::delete('/{order}', 'OrderDeleteAPIController@delete');
        });
    });

});
