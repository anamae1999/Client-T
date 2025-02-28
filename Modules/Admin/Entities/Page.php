<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
	protected $fillable = ['user_id','page_titles','meta_titles','meta_descriptions','meta_keywords','slugs'];

    function section() {
    	return $this->hasMany('Modules\Admin\Entities\Section');
    }

    function user() {
    	return $this->belongsTo('App\User');
    }
}
