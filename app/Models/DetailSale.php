<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailSale extends Model
{
    use HasFactory;

    protected $table = "detail_sales";

    protected $fillable = [
        'product_id', 'sales_id', 'variants'
    ];

    public $timestamps = false;
}
