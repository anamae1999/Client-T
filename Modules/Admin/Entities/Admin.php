<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $fillable = [];

    function user() {
        return $this->belongsTo('App\User');
    }
}
