<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    protected $fillable =[

        "reference_no", "status", "from_warehouse_id", "to_warehouse_id", "item", "total_qty", "total_tax", "total_cost", "shipping_cost", "grand_total", "document", "note"
    ];
}
