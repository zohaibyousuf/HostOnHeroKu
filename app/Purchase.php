<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable =[

        "reference_no", "user_id", "supplier", "item", "total_qty", "total_cost", "shipping_cost", "grand_total", "note"
    ];
}
