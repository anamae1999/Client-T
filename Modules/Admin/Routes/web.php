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

Route::prefix('admin')->group(function() {
    Route::get('/', function () {
        return redirect('admin/dashboard');
    });

    // Get routes
    Route::get('pages/new-blog', 'ContentController@newBlog');
    Route::get('pages', 'PageController@showPage');
    Route::get('pages/edit/{slug}', 'ContentController@editPage');         
    Route::get('pages/manage-faq', 'FaqController@index');
    Route::get('pages/manage-testimonials', 'TestimonialController@index');
    Route::get('pages/manage-categories', 'CategoryController@index');
    Route::get('pages/manage-awards-and-certifications', 'AwardController@index');
    Route::get('pages/manage-cookie-settings', 'CookieContentController@index');
    Route::get('pages/manage-team-members', 'MembersController@index');
    Route::get('pages/edit/cookie-item/{id}', 'CookieContentController@edit'); 
    Route::get('pages/edit/faq/{id}', 'FaqController@edit'); 
    Route::get('users', 'UserController@show');
    Route::get('vetting', 'VettingController@index');
    Route::get('dashboard', 'AdminController@index');

    Route::get('/users/search', 'UserController@searchUser');
    Route::get('/mentors/search', 'UserController@searchMentor');
    Route::get('/vetting/search', 'VettingController@search');
    Route::get('/screening/search', 'VettingController@search');

    Route::get('settings', 'AdminController@accountSettings');
    
    // Post routes
    Route::post('update-content/{id}', 'ContentController@updateContent');
    Route::post('update-meta/{id}', 'PageController@updateMeta');   
    Route::post('add-faq', 'FaqController@store');
    Route::post('update-faq/{id}', 'FaqController@update');
    Route::post('add-testimonial', 'TestimonialController@store');
    Route::post('add-awards-and-certifications', 'AwardController@store');
    Route::post('add-cookie-setting', 'CookieContentController@store');
    Route::post('add-member', 'MembersController@store');
    Route::post('update-cookie-setting/{id}', 'CookieContentController@update');
    Route::post('member/update/{id}', 'MembersController@update');
    Route::post('testimonial/update', 'TestimonialController@update');
    Route::post('awards-and-certifications/update', 'AwardController@update');
    Route::post('/editUser', 'UserController@editUser');

    Route::post('add-category', 'CategoryController@store');
    Route::post('update-category', 'CategoryController@update');

    Route::post('/user/suspend', 'UserController@suspendUser');
    Route::post('/user/block', 'UserController@blockUser');
    Route::post('/user/activate', 'UserController@activateUser');
    Route::post('/user/update', 'UserController@updateUser');

    Route::post('/mentor/create', 'MentorUserController@create');

    Route::post('/vetting/update-remarks', 'VettingController@updateRemarks');
    Route::post('/vetting/process', 'VettingController@process');
    Route::post('/vetting/pend', 'VettingController@pend');
    Route::post('/vetting/passed', 'VettingController@passed');
    Route::post('/vetting/failed', 'VettingController@failed');

    Route::post('/screening/update-remarks', 'VettingController@updateRemarks');
    Route::post('/screening/process', 'VettingController@process');
    Route::post('/screening/pend', 'VettingController@pend');
    Route::post('/screening/passed', 'VettingController@passed');
    Route::post('/screening/failed', 'VettingController@failed');
    Route::post('/screening/update-badge', 'VettingController@updateBadge');

    Route::post('/settings/savehtml', 'AdminController@savehtml');
    Route::post('/settings/update-price', 'AdminController@updatePrice');
    Route::post('/settings/toggle-vetting', 'AdminController@toggleVetting');
    Route::post('/settings/add-badge', 'AdminController@addBadge');
    Route::post('/settings/add-sample-photo', 'AdminController@addExamplePhoto');
    Route::post('/settings/toggle-cookie', 'AdminController@toggleCookie');
    Route::post('/settings/cookie-notice', 'AdminController@updateCookieNotice');
    Route::post('/settings/update-notice', 'AdminController@updateNotice');
    Route::post('/settings/update-social', 'AdminController@updateSocial');
    Route::post('/settings/update-footer', 'AdminController@updateFooter');
    Route::post('/settings/update-tooltip', 'AdminController@updateTooltip');
    Route::post('/settings/update-photo-example', 'AdminController@updateProfileExampleText');

    // Delete Routes
    Route::delete('faq/delete', 'FaqController@destroy');  
    Route::delete('/user/delete', 'UserController@deleteUser');
    Route::delete('testimonial/delete', 'TestimonialController@destroy');
    Route::delete('awards-and-certifications/delete', 'AwardController@destroy');
    Route::delete('cookie-setting/delete', 'CookieContentController@destroy');
    Route::delete('member/delete', 'MembersController@destroy');
    Route::delete('delete-category', 'CategoryController@destroy');
    Route::delete('delete-badge', 'AdminController@destroyBadge'); 
    Route::delete('delete-photoSample', 'AdminController@destroyPhotoExample'); 

    // Patch Route
    Route::patch('/settings/update', 'AdminController@updateAdmin');
});

 // Get routes
Route::get('home', function () {
    return redirect('/');
});

Route::get('/', 'ContentController@showPage')->name('home');
Route::get('about-us', 'ContentController@showPage');
Route::get('faq', 'ContentController@showPage');
Route::get('contact', 'ContentController@showPage');
Route::get('how-it-works', 'ContentController@showPage');
Route::get('terms-of-service', 'ContentController@showPage');
Route::get('privacy-policy', 'ContentController@showPage');
Route::get('cookie-statement', 'ContentController@showPage');
Route::get('thank-you', 'ContentController@showPage');

// search routes
Route::get('search', 'PageController@search');
Route::get('search/{role}', 'PageController@listProfile');
Route::get('search/{role}/location', 'PageController@searchLocation');
Route::get('search/{role}/job', 'PageController@searchJob');
Route::get('search/{role}/advanced', 'PageController@searchAdvanced');
Route::get('search/nannies/{jobDesc}', 'PageController@searchDescription');

Route::get('reactivate', 'UserController@reactivateUser')->name('reactivate');

Route::post('/add/testimonial', 'TestimonialController@submitted');


