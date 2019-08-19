<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class basic_page extends Model
{
    protected $table = 'basic_page';#else it doesn't work, laravel will look for basic_pages(with a s)
}
