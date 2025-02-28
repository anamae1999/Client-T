<?php

namespace Modules\Nannies\Entities;

use Illuminate\Database\Eloquent\Model;

class Reference extends Model
{
    protected $fillable = ['user_id','sitter_id','first_name','last_name','contact_number','email'];

    function user(){
    	return $this->belongsTo('App\User');
    }
}
