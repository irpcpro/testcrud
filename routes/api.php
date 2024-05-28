<?php

use Illuminate\Support\Facades\Route;


Route::prefix('v1')->namespace('V1')->group(function () {

    // authentication
    Route::prefix('auth')->namespace('Auth')->group(function () {
        Route::post('/register', 'RegisterAPIController@register');
        Route::post('/login', 'LoginAPIController@login');
    });

    // private routes
    Route::middleware('auth:api')->group(function(){

    });

});
