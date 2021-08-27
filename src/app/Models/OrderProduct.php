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

    public function scopeFindById($query, $id)
    {
        return $query->find($id);
    }

    public function scopeGetMostProducts($query)
    {
        return $query->selectRaw('product_id, created_at, COUNT(amount_of) AS count_products')
            ->groupBy('product_id')
            ->orderBy('count_products', 'DESC');
    }

    public function scopeGetByBetweenDay($query, $dayOne, $dayTwo)
    {
        return $query->whereBetween('created_at', [$dayOne, $dayTwo]);
    }

    public function scopeGetDayNow($query)
    {
        return $query->where('created_at', '>=', date('Y-m-d').' 00:00:00');
    }
}
