<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

//
//Auth::routes();

Route::get('/', "HomeController@index");
Route::get('/profileType', "HomeController@index");
Route::get('/slotType', "HomeController@index");
Route::get('/slotTypeDetails', "HomeController@index");
Route::get('/organizationalStructure', "HomeController@index");
