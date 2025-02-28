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

Route::prefix('blog')->group(function() {
    Route::get('/', 'BlogController@index');

	Route::view('inner', 'blog::bloginner');

	// Get routes
	Route::get('pages/edit/post/{id}', 'PostController@edit');
	Route::get('/inner/{slug}', 'PostController@show');
	Route::get('search', 'PostController@search');
	Route::get('/{category_name}', 'BlogController@categorized');

	// Post routes
	Route::post('store', 'PostController@store');
	Route::post('update/{id}', 'PostController@update');
	Route::post('add-comment/{id}', 'PostController@addComment');
	Route::post('update-comment/{id}', 'PostController@updateComment');

	// Delete routes
	Route::delete('post/delete', 'PostController@destroy');
	Route::delete('/comment/{id}/delete', 'PostController@deleteComment');
});


