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

use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
//    return view('welcome');
//});

//Auth::routes();

// Authentication Routes...
Route::get('admin/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('admin/login', 'Auth\LoginController@login');
Route::post('admin/logout', 'Auth\LoginController@logout')->name('logout');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');


Route::get('/image/{image}', 'ImageController@image')->name('image');
//Route::post('/thumbnail/{image}', 'ImageController@thumbnail')->name('thumbnail');

Route::group(['middleware' => 'auth', 'prefix' => '/admin'], function () {
    Route::get('/', 'HomeController@index')->name('admin');

    Route::get('/optimize', 'PhotoController@getResize')->name('resize');
    Route::get('/optimize-list', 'PhotoController@getResize')->name('resize');
    Route::patch('/optimize/{photo}', 'PhotoController@optimize')->name('optimize');

    Route::get('/gallery', 'PhotoController@index')->name('gallery');
    Route::post('/gallery', 'PhotoController@store')->name('gallery.store');
    Route::get('/gallery/trash', 'PhotoController@trash')->name('gallery.trash');
    Route::patch('/gallery/trash/{photo}', 'PhotoController@restore')->name('gallery.restore');
    Route::delete('/gallery/{photo}', 'PhotoController@destroy')->name('gallery.destroy');

    Route::get('/description', 'DescriptionController@index')->name('description');
    Route::post('/description', 'DescriptionController@store')->name('description.store');
    Route::get('/description/trash', 'DescriptionController@trash')->name('description.trash');
    Route::get('/description/trash/{description}', 'DescriptionController@show')->name('description.show');
    Route::patch('/description/trash/{description}', 'DescriptionController@restore')->name('description.restore');
    Route::get('/description/{id}', 'DescriptionController@photoRestore')->name('description.photo');
    Route::delete('/description/{description}', 'DescriptionController@destroy')->name('description.destroy');

    Route::get('/carousel', 'CoverPhotoController@index');
    Route::post('/carousel', 'CoverPhotoController@store')->name('carousel');
    Route::get('/carousel/removed', 'CoverPhotoController@removed')->name('carousel.removed');
    Route::patch('/carousel/removed/{photo}', 'CoverPhotoController@restore')->name('carousel.restore');
    Route::patch('/carousel/{photo}', 'CoverPhotoController@remove')->name('carousel.remove');

    Route::get('/layout', 'LayoutController@index');
    Route::post('/layout', 'LayoutController@store')->name('layout');
    Route::get('/layout/create', 'LayoutController@create')->name('layout.create');
    Route::get('/layout/description', 'LayoutController@description');
    Route::patch('/layout/description', 'LayoutController@descriptionUpdate')->name('layout.description');
    Route::get('/layout/{layout}/edit', 'LayoutController@edit')->name('layout.edit');
    Route::patch('/layout/{layout}', 'LayoutController@update')->name('layout.update');
    Route::delete('/layout/{layout}', 'LayoutController@destroy')->name('layout.destroy');
    Route::get('/layout/trash', 'LayoutController@trash')->name('layout.trash');  ///need to be update
    Route::patch('/layout/trash/{layout}', 'LayoutController@restore')->name('layout.restore');

    Route::get('/layout/{layout}', 'LayoutController@show')->name('layout.show');

});

Route::view('/{path?}', 'page');
Route::view('/{path?}/{path1?}', 'page');
