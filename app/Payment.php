<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable =[

        "sale_id", "payment_reference", "amount", "payment_method"
    ];
}
