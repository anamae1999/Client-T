<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    function page() {
    	return $this->belongsTo('Modules\Admin\Entities\Page');
    }

    function content() {
    	return $this->hasMany('Modules\Admin\Entities\Content');
    }
}
