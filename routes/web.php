<?php

use App\User;
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

Auth::routes(['verify' => true]);

Route::view('/blocked', 'status.blocked');
Route::view('/suspended', 'status.suspended');

// chat app routes
Route::get('/contacts', 'ContactsController@get');
Route::get('/self', 'ContactsController@getSelf');
Route::get('/conversation/{id}', 'ContactsController@getMessagesFor');
Route::post('/conversation/sender', 'ContactsController@sender');
Route::post('/contact/add/{id}', 'ContactsController@addContact');
Route::delete('/contact/delete', 'ContactsController@deleteContact');
Route::post('/update-notification', 'ContactsController@updateNotif');
Route::get('/nullify-talk', 'ContactsController@removeTalkingTo');

// Payment routes

// Card payment routes
Route::post('subscription/{id}', 'PaymentsController@create');
Route::post('cancel-subscription/{id}', 'PaymentsController@cancelSubscription');

// Webhook for cards
Route::post(
    'stripe/webhook',
    '\App\Http\Controllers\WebhookController@handleWebhook'
);

// Ideal payment routes
Route::post('ideal-payment/{id}', 'PaymentsController@createSource');
// Route::get('test-ideal', 'PaymentsController@chargeIdealSrc');
// Route::get('charge-source', 'PaymentsController@chargeIdealSrc')->name('charge-source');

// Mail routes
Route::post('form-send', 'MailController@formEmail');
Route::get('premium-send', 'MailController@premiumSuccess')->name('premium-notif');

// overwrite/disable default auth routes
Route::view('login', 'errors.404');
Route::view('register', 'errors.404');
Route::post('login', 'Auth\LoginController@login')->name('login');
Route::post('register', 'Auth\RegisterController@register')->name('register');

Route::get('notification', 'MailController@notifs');

// Webhook for Ideal
Route::stripeWebhooks('stripe-webhook');

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
 \UniSharp\LaravelFilemanager\Lfm::routes();
});

// email browser tester
// use App\Notifications\VerifyEmail;
// Route::get('mail-preview', function () {
// 	$notifiable = new User();
//     $notifiable->first_name = 'First'; 
//     $notifiable->last_name = 'Last'; 
//     $notifiable->plan = '1 Month';
//     $notifiable->brand = 'Visa';
//     $notifiable->cardFour = '4242';
//     $notifiable->prospect = 'sitter';
//     return (new VerifyEmail())->toMail($notifiable);
// });

// markdown browser tester
// $router->get('/notification', function () {

//     $recipient = new User();
// 	$recipient->name = 'Emmanuelle'; 
//     $recipient->email = 'evabendan@straightarrow.com.ph';   // This is the email you want to send to.
//     $recipient->prospect = 'family';
//     $recipient->subsEnd =  'Jan 01, 2022';               
//     $recipient->plan =  '3 Months';
//     $recipient->phrase =  'family for you';
//     $recipient->end_date = '12/01/2020';
//     $recipient->cardFour = '4242';
//     $recipient->brand = 'Visa';


//     $notification = (new \App\Notifications\PremiumMembershipCard)->toMail($recipient);

//     $markdown = new \Illuminate\Mail\Markdown(view(), config('mail.markdown'));

//     return $markdown->render($notification->markdown, $notification->data());
// });

Route::get('/notification/{email}', 'MailController@previewMail');
