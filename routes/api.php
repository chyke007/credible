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
Route::post('login', 'Auth\ApiController@login');
Route::post('register', 'Auth\ApiController@register');

 
//Secured routes
Route::group(['middleware' => 'auth:api'], function(){
    // Route::get('logout', 'Auth\ApiController@logout');
    Route::apiresource('user','UserController')->except(['show']);
    Route::apiresource('transfer','TransferController')->except(['show']);
 
});
