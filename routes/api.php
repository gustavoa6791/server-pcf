<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/profileType', 'SsoGroupProfileTypeController@store');
Route::get('/profileType', 'SsoGroupProfileTypeController@get');
Route::match(['put'], '/profileType/{id}', 'SsoGroupProfileTypeController@edit');
Route::delete('/profileType/{id}', 'SsoGroupProfileTypeController@delete');
Route::delete('/profileType/verify/{id}', 'SsoGroupProfileTypeController@deleteVerify');

Route::get('/slotType', 'SchSlotTypeController@get');
Route::get('/slotType/{id}', 'SchSlotTypeController@find');
Route::post('/slotType', 'SchSlotTypeController@store');
Route::match(['put'], '/slotType/{id}', 'SchSlotTypeController@edit');
Route::delete('/slotType/{id}', 'SchSlotTypeController@delete');
Route::delete('/slotType/verify/{id}', 'SchSlotTypeController@deleteVerify');

Route::get('/attentionType/{id}', 'SchAttentionTypeController@find');
Route::post('/attentionType', 'SchAttentionTypeController@store');

Route::get('/service', 'SchAttentionTypeController@getService');
Route::match(['put'], '/service/{id}', 'SchAttentionTypeController@updateService');
Route::delete('/service/{id}', 'SchAttentionTypeController@deleteService');
