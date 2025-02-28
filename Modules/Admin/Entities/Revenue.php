<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;

class Revenue extends Model
{
    protected $fillable = ['month','year','role','revenue'];
}
