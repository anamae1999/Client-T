<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    function user() {
        return $this->belongsTo('App\User');
    }
}
