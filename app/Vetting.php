<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vetting extends Model
{
    protected $fillable = ['user_id','application_status','remarks','status'];
	
    function user() {
        return $this->belongsTo('App\User');
    }
}
