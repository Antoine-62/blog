<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use Fomvasss\UrlAliases\Traits\UrlAliasable;

class _product extends Model
{
    protected $table = '_product';#else it doesn't work, laravel will look for test_form5s
}
