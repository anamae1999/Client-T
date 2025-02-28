<?php

namespace Modules\Blog\Entities;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    function posts() {
    	return $this->belongsToMany('Modules\Blog\Entities\Post');
    }
}
