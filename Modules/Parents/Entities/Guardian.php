<?php

namespace Modules\Parents\Entities;

use Illuminate\Database\Eloquent\Model;

class Guardian extends Model
{
    protected $fillable = ['user_id','house_number','street','city','zip_code','job_description','hourly_rate','num_of_children','gender_of_children','age_of_children','eldest_child','youngest_child','mother_tongue','languages','stages_experience','additional_services','activities','general_text','profile_pic'];

    function user() {
        return $this->belongsTo('App\User');
    }
}


