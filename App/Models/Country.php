<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
	use SoftDeletes;
	
    public $fillable = ['name','country_code','status'];
}
