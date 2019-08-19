<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class _product_q extends Model
{
    protected $table = '_product_q';#else it doesn't work, laravel will look for test_form5s
}
