<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\Status;

class Product extends Model
{
    use HasFactory;
    protected $table = "products";
    protected $primaryKey = "id";
    protected $guarded = [];

    public function categories()
    {
        return $this->belongsTo(Categories::class,'category_id');
    }

    public function order_product()
    {
        return $this->hasMany(OrderProduct::class,'product_id');
    }

    public function evaluates()
    {
        return $this->hasMany(Evaluates::class,'product_id');
    }

    public function images()
    {
        return $this->hasMany(Image::class,'product_id');
    }

    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeSearchName($query, $keyword)
    {
        return $query->where('name', 'like', '%' . $keyword . '%');
    }

    public function scopeProductDetail($query, $slug)
    {
        return $query->where([
            'status' => Status::ACTIVE,
            'slug'   => $slug,
        ])->orderBy('updated_at', 'DESC');

    }

    public function scopeDecrementProduct($query, $productId, $quantity)
    {
        return $query->find($productId)->decrement('amount_of', $quantity);
    }

    public function scopeFindName($query, $name)
    {
        return $query->where('name', $name);
    }
}
