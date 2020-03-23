<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', 'ApiController@login');
Route::post('/register', 'ApiController@register');

Route::group(['middleware' => 'auth.jwt'], function () {
    Route::get('/logout', 'ApiController@logout');

    /**
     * Categories
     */
    Route::get('/categories', 'CategoryController@index');
    Route::post('/categories', 'CategoryController@store');

    /**
     * Cards
     */
    Route::group(['prefix' => 'cards'], function() {
        Route::get('/', 'CardController@index');
        Route::get('/{id}/show', 'CardController@show');
        Route::post('/', 'CardController@store');
        Route::put('/{id}/update', 'CardController@update');
        Route::delete('/{id}/delete', 'CardController@delete');
    });
});
