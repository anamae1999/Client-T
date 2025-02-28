<?php

namespace Modules\Mentors\Entities;

use Illuminate\Database\Eloquent\Model;

class EventDetail extends Model
{
    protected $fillable = ['agenda_id','dates','start_time','end_time','venue','language','fee','promo'];

    function agenda() {
        return $this->belongsTo('Modules\Mentors\Entities\Agenda');
    }
}
