<?php

namespace Modules\Mentors\Entities;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    protected $fillable = ['title','description'];

    function user() {
        return $this->belongsTo('App\User');
    }

    function details() {
        return $this->hasMany('Modules\Mentors\Entities\EventDetail');
    }
}
