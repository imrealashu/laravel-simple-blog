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

Auth::routes();

Route::get('/', 'PostController@index')->name('home');
Route::get('/post/show/{slug}', 'PostController@show');
Route::get('/search', 'PostController@search')->name('search');

Route::group(['middleware' => 'auth'], function(){
    Route::get('/post/create', 'PostController@create');
    Route::get('/post/edit/{slug}', 'PostController@edit');
    Route::get('/posts', 'UserController@posts');
});
