<?php

// Sitter Profile Model

namespace Modules\Nannies\Entities;

use Illuminate\Database\Eloquent\Model;

class Sitter extends Model
{
	protected $fillable = ['user_id','house_number','street','city','zip_code','date_of_birth','hourly_rate','gender','job_description','years_of_experience','mother_tongue','languages','stages_experience','activities','qualifications','additional_services','general_text','profile_pic','begin_date','contact_number'];

    function user() {
        return $this->belongsTo('App\User');
    }
}



