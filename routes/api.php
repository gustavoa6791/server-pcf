<?php

use Illuminate\Http\Request;


 Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
 });

Route::post('/', 'SsoGroupProfileTypeController@store');

Route::get('/', 'SsoGroupProfileTypeController@get');

Route::get('/{filter}/{filterState}', 'SsoGroupProfileTypeController@search');

Route::match(['put'], '/{id}', 'SsoGroupProfileTypeController@edit');

Route::delete('/{id}', 'SsoGroupProfileTypeController@delete');