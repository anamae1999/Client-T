<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
	protected $fillable = ['contents'];

    function section() {
    	return $this->belongsTo('Modules\Admin\Entities\Section');
    }
}
