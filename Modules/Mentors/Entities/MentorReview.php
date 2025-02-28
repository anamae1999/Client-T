<?php

namespace Modules\Mentors\Entities;

use Illuminate\Database\Eloquent\Model;

class MentorReview extends Model
{
    protected $fillable = ['user_id','sitter_id','review'];

    function user(){
    	return $this->belongsTo('App\User');
    }
}
