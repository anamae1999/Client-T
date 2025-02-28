<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $fillable = ['category','question','answer'];
}
