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

Route::prefix('parents')->group(function() {
    

    // route get
    // Route::get('/', function () {
    //     return redirect('/parents/dashboard');
    // });

    Route::redirect('/', '/parents/dashboard', 301);

	Route::get('/profile/{id}/{fname}', 'GuardianController@show');
    Route::get('/dashboard', 'GuardianController@dashboard');
    Route::get('/settings', 'GuardianController@settings');
    Route::get('/messages', 'GuardianController@messages');

    // route post
    Route::post('update', 'GuardianController@update');
    Route::post('delete', 'GuardianController@deleteAccount');
    Route::post('deactivate', 'GuardianController@deactivateAccount');

    // route patch
    Route::patch('update-settings', 'GuardianController@updateSettings');
}); 
