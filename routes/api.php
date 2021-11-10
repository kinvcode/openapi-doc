<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::namespace('V1')->prefix('v1')->group(function(){
    Route::get('version','IndexController@version');
    Route::get('users/{id}','IndexController@userInfo');
    Route::get('user/name','IndexController@userName');
    Route::get('user/id','IndexController@userID');
    Route::get('debug','IndexController@debug');
    Route::post('auth/register','IndexController@register');
    Route::post('auth/login','IndexController@login');
    Route::get('response','IndexController@response');
    Route::post('request','IndexController@request');
    Route::post('request/file','IndexController@requestFile');

    Route::middleware('auth:api')->group(function(){
        Route::get('me/collection/{id}','IndexController@myCollection');
    });
});
