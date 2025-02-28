<?php

namespace Modules\Mentors\Entities;

use Illuminate\Database\Eloquent\Model;

class Mentor extends Model
{
    protected $fillable = ['user_id','house_number','street','city','zip_code','job_description','trainings','languages','email','number','website','general_text','profile_pic'];

    function user() {
        return $this->belongsTo('App\User');
    }
}
