<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = ['testi_content','testi_author','testi_rating'];
}
