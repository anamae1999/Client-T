<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
	protected $guarded = [];
	
    public function fromContact()
    {
        return $this->hasOne(User::class, 'id', 'from');
    }

   
    public function getCreatedAtAttribute($value){

    	$time = strtotime($value);

		$newformat = date('d/m/y H:i:s',$time);

        return $newformat;
    }
}
