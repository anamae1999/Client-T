<?php

namespace Modules\Blog\Entities;

use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    protected $fillable = ['name','email'];

    function comments() {
        return $this->hasMany('Modules\Blog\Entities\Comment');
    }
}
