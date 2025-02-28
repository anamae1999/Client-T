<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;

class Award extends Model
{
    protected $fillable = ['award_image','award_title'];
}
