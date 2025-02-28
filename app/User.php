<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;


use Cache;

use Laravel\Cashier\Billable;

use App\Notifications\VerifyEmail;
use App\Notifications\ResetPasswordNotificationEmail;

class User extends Authenticatable implements MustVerifyEmail
{
	use Notifiable;
	use Billable;
	use SoftDeletes;

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
	protected $fillable = [
		'first_name', 'last_name', 'email', 'password', 'role', 'account_status', 'account_type', 'lat', 'lon',
	];

	protected $dates = ['deleted_at']; 

	/**
	* The attributes that should be hidden for arrays.
	*
	* @var array
	*/
	protected $hidden = [
		'password', 'remember_token',
	];

	/**
	* The attributes that should be cast to native types.
	*
	* @var array
	*/
	protected $casts = [
		'email_verified_at' => 'datetime',
	];

	public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail);
    }

	public function isOnline()
	{
	    return Cache::has('user-is-online-' . $this->id);
	}

	function admin() {
        return $this->hasOne('Modules\Admin\Entities\Admin');
	}

	function posts() {
        return $this->hasMany('Modules\Blog\Entities\Post');
    }

    function comments() {
        return $this->hasMany('Modules\Blog\Entities\Comment');
    }

    function sitterProfile() {
        return $this->hasOne('Modules\Nannies\Entities\Sitter');
	}

	function guardianProfile() {
        return $this->hasOne('Modules\Parents\Entities\Guardian');
	}

	function mentorProfile() {
        return $this->hasOne('Modules\Mentors\Entities\Mentor');
	}
	
	function schedule() {
        return $this->hasOne('App\Schedule');
	}

	function pages() {
        return $this->hasMany('Modules\Admin\Entities\Page');
    }

    function messages() {
        return $this->hasMany('App\Message');
    }

    function vetting() {
        return $this->hasOne('App\Vetting');
    }

	function screening() {
        return $this->hasOne('App\Screening');
    }

    function contact() {
        return $this->hasMany('App\Contact');
    }

    function idealSubscription() {
        return $this->hasOne('App\IdealSubscription');
    }
    function agendas() {
        return $this->hasMany('Modules\Mentors\Entities\Agenda');
    }
    function references() {
        return $this->hasMany('Modules\Nannies\Entities\Reference');
    }
    public function sendPasswordResetNotification($token)
	{
	    $this->notify(new ResetPasswordNotificationEmail($token));
	}
}