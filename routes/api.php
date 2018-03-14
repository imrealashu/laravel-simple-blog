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

Route::group(['middleware' => 'auth:api'], function(){
    # Post Routes
    Route::post('/post/create', 'PostController@store');
    Route::post('/post/update/{slug}', 'PostController@update');
    Route::delete('/post/delete/{slug}', 'PostController@delete');

    # Comment Routes
    Route::post('/comment/{postId}', 'CommentController@store');
    Route::delete('/comment/{id}', 'CommentController@delete');
});
