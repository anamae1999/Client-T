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

Route::prefix('mentors')->group(function() {
    Route::redirect('/', '/mentors/dashboard', 301);
    
    Route::get('/profile/{id}/{fname}', 'MentorsController@show');
    Route::get('/dashboard', 'MentorsController@dashboard'); 
    Route::get('/settings', 'MentorsController@settings');
    Route::get('/messages', 'MentorsController@messages');
    Route::get('/agendas', 'MentorsController@agendas');
    Route::get('/edit-agenda/{id}', 'AgendaController@edit'); 

	Route::get('/manage-agendas', 'AgendaController@index');

    // route post
    Route::post('/update', 'MentorsController@update'); 
    Route::post('/add-agenda', 'AgendaController@create');  
    Route::post('/deactivate', 'MentorsController@deactivateAccount');
    Route::post('/delete', 'MentorsController@deleteAccount');

    Route::post('/review/{mentor_id}', 'MentorReviewController@create');
    Route::post('/update-agenda/{id}', 'AgendaController@update');

    // route patch
    Route::patch('/update-settings', 'MentorsController@updateSettings');

    // route delete
    Route::delete('/review/delete/{review_id}', 'MentorReviewController@delete');
    Route::delete('/agenda/delete', 'AgendaController@destroy');
});
