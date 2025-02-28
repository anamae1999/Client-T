<?php

namespace Modules\Blog\Entities;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
	protected $fillable = ['user_id','guest_id','post_id','comment','website'];

    function user(){
    	return $this->belongsTo('App\User');
    }

    function guest(){
    	return $this->belongsTo('Modules\Blog\Entities\Guest');
    }

}
