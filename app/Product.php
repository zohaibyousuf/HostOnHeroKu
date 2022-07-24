<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable =[

        "name", "brand", "category_id", "model_no", "qty", "image", "product_details", "is_active", "barcode_symbology", "unit", "alert_qty", "price"
    ];
}
