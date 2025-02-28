<?php

namespace Modules\Blog\Entities;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
	protected $fillable = ['user_id','category_id','post_title','post_body','post_image'];

    function category() {
    	return $this->hasOne('Modules\Blog\Entities\Category');
    }

    function comments() {
    	return $this->hasMany('Modules\Blog\Entities\Comment');
    }

    function user() {
    	return $this->belongsTo('App\User');
    }

}
