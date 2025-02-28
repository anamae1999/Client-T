<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
	protected $fillable = ['user_id'];
	
    function user() {
        return $this->belongsTo('App\User');
    }
}
