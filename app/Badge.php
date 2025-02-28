<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    function screening() {
        return $this->belongsTo('App\Screening');
    }
}
