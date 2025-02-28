<?php

namespace Modules\Nannies\Entities;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['user_id','sitter_id','review'];

    function user(){
    	return $this->belongsTo('App\User');
    }
}
