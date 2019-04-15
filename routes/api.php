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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/optimize-list', 'PhotoController@optimizeList')->name('optimize-list');
Route::get('/home', 'LayoutController@home')->middleware('cors');
Route::get('/gallery', 'PhotoController@gallery')->middleware('cors');
Route::post('/contact', 'ContactController@store');
