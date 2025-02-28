<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IdealSubscription extends Model
{
    protected $fillable = ['user_id','name','started_at','ends_at'];

    protected $dates = ['ends_at'];    
	
    function user() {
        return $this->belongsTo('App\User');
    }
}
