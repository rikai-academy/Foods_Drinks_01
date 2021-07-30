<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;
    protected $table = "order_product";
    protected $primaryKey = "id";
    protected $guarded = [];

    public function orders()
    {
        return $this->belongsTo(Order::class,'order_id');
    }

    public function products()
    {
        return $this->belongsTo(Product::class,'product_id');
    }
}