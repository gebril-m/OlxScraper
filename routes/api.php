<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('user/register','UserAuthController@register');
Route::post('user/login','UserAuthController@login');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('get_number_of_pagination','ScrapingController@get_number_of_pagination');
Route::get('get_number_of_ads','ScrapingController@get_number_of_ads');
Route::get('store_ads','ScrapingController@store_ads');
