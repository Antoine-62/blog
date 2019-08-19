<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class file extends Model
{
     protected $table = ['file'];#else it doesn't work, laravel will look for test_form5s
}
