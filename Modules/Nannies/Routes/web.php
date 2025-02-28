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

Route::prefix('nannies')->group(function() {
    

    // route get
    // Route::get('/', function () {
    //     return redirect('/nannies/dashboard');
    // });

    Route::redirect('/', '/nannies/dashboard', 301);

	Route::get('/profile/{id}/{fname}', 'SitterController@show');
    Route::get('/dashboard', 'SitterController@dashboard');
    Route::get('/settings', 'SitterController@settings');
    Route::get('/messages', 'SitterController@messages');

    // route post
    Route::post('/update', 'SitterController@update');
    Route::post('/profile', 'SitterController@profile');
    Route::post('/deactivate', 'SitterController@deactivateAccount');

    Route::post('/request/vetting', 'SitterController@requestVetting');

    Route::post('/review/{sitter_id}', 'ReviewsController@create');

    Route::post('/delete', 'SitterController@deleteAccount');

    // route patch
    Route::patch('/update-settings', 'SitterController@updateSettings');
    
    // route delete
    Route::delete('/cancel/vetting', 'SitterController@cancelVetting');
    Route::delete('/review/delete/{review_id}', 'ReviewsController@delete');
    
});








