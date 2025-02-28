<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Screening extends Model
{
    protected $fillable = ['user_id','application_status','remarks','status','badge_name','badge_name2','bandge_img1','bandge_img2','bandge_img3','bandge_img4','bandge_img5'];
	
    function user() {
        return $this->belongsTo('App\User');
    }
    
    function badge() {
        return $this->belongsTo('App\Badge');
	}
}
