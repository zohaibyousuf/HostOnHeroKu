<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductReturn extends Model
{
    protected $table = 'product_returns';
    protected $fillable =[

        "return_id", "product_id", "qty", "unit", "product_price", "total"
    ];
}
