<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Returns extends Model
{
    protected $fillable =[

        "reference_no", "customer_id", "user_id", "item", "total_qty", "total_price", "grand_total", "note"
    ];
}
