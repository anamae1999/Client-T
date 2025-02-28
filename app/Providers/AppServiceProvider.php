<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

use Illuminate\Support\Facades\Validator;

use View;
use Modules\Admin\Entities\Setting;
use Modules\Admin\Entities\CookieSetting;

class AppServiceProvider extends ServiceProvider
{
	/**
	* Register any application services.
	*
	* @return void
	*/
	public function register()
    {
        // $this->app->bind('path.public', function() {
        // return base_path('public_html');
        // });
    }

	/**
	* Bootstrap any application services.
	*
	* @return void
	*/
	public function boot()
    {
        Schema::defaultStringLength(191);

        Validator::extend('recaptcha', 'App\\Validators\\ReCaptcha@validate');

        if (Schema::hasTable('settings')) {
        	$settings = Setting::find(1);
	        $cookieSettings = CookieSetting::all();
	        
	        View::share(['settings'=>$settings,'cookieSettings'=>$cookieSettings]);
        }      
    }

}