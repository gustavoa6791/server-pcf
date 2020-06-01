<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/profileType', 'SsoGroupProfileTypeController@get');
Route::post('/profileType', 'SsoGroupProfileTypeController@store');
Route::match(['put'], '/profileType/{id}', 'SsoGroupProfileTypeController@edit');
Route::delete('/profileType/{id}', 'SsoGroupProfileTypeController@delete');
Route::delete('/profileType/verify/{id}', 'SsoGroupProfileTypeController@deleteVerify');

Route::get('/slotType', 'SchSlotTypeController@get');
Route::get('/slotType/{id}', 'SchSlotTypeController@find');
Route::get('/plan', 'SchSlotTypeController@getPlan');
Route::post('/slotType', 'SchSlotTypeController@store');
Route::match(['put'], '/slotType/{id}', 'SchSlotTypeController@edit');
Route::delete('/slotType/{id}', 'SchSlotTypeController@delete');
Route::delete('/slotType/verify/{id}', 'SchSlotTypeController@deleteVerify');

Route::get('/attentionType/{id}', 'SchAttentionTypeController@find');
Route::post('/attentionType', 'SchAttentionTypeController@store');
Route::match(['put'], '/attentionType/{id}', 'SchAttentionTypeController@edit');
Route::delete('/attentionType/{id}', 'SchAttentionTypeController@delete');
Route::get('/template', 'SchAttentionTypeController@getTemplate');

Route::get('/service', 'SchAttentionTypeController@getService');
Route::match(['put'], '/service/{id}', 'SchAttentionTypeController@updateService');
Route::delete('/service/{id}', 'SchAttentionTypeController@deleteService');

Route::get('/orgStructure', 'GblOrgStructureController@get');
Route::post('/orgStructure', 'GblOrgStructureController@store');
Route::match(['put'], '/orgStructure/{id}', 'GblOrgStructureController@edit');
Route::delete('/orgStructure/{id}', 'GblOrgStructureController@delete');
Route::post('/admission', 'GblOrgStructureController@storeAdmission');
Route::match(['put'], '/admission/{id}', 'GblOrgStructureController@editAdmission');
Route::delete('/admission/{id}', 'GblOrgStructureController@deleteAdmission');
Route::post('/attention', 'GblOrgStructureController@storeAttention');
Route::match(['put'], '/attention/{id}', 'GblOrgStructureController@editAttention');
Route::delete('/attention/{id}', 'GblOrgStructureController@deleteAttention');
Route::get('/permission', 'GblOrgStructureController@getPermission');
Route::post('/permission', 'GblOrgStructureController@updatePermission');
Route::delete('/permission/{id}', 'GblOrgStructureController@deletePermission');
Route::post('/permissionAttention', 'GblOrgStructureController@updatePermissionAttention');
Route::delete('/permissionAttention/{id}', 'GblOrgStructureController@deletePermissionAttention');
