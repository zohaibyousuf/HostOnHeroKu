<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductSale extends Model
{
	protected $table = 'product_sales';
    protected $fillable =[

        "sale_id", "product_id", "qty", "unit", "product_price", "total"
    ];
}
