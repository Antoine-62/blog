<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Fomvasss\UrlAliases\Traits\UrlAliasable;

class url_aliases extends Model
{
    protected $table = 'url_aliases';
	protected $fillable = ['source'];
}
