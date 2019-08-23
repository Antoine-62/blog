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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('ProductEdit', 'ProductController');
Route::get('MemberEdit/{slug}', 'ProductController@show2');
Route::resource('MyProfil', 'UserController');
Route::get('display-User', 'UserController@showall');
Route::get('faq', 'FaqController@show');
Route::get('display-Permission', 'PermissionController@show');
Route::get('Home2', 'AdminController@showHome');
Route::get('About-us', 'AdminController@showAbout');
Route::get('Contact-us', 'AdminController@showContact');