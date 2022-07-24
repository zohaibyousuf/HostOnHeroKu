<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable =[
        "name", "company_name",
        "email", "phone", "address", "is_active"
    ];
}
