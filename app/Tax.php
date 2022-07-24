<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    protected $fillable =[
        "name", "rate"
    ];

    public function product()
    {
    	return $this->hasMany('App/Product');
    	
    }
}
