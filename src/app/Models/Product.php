<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\Status;
use Laravel\Scout\Searchable;

class Product extends Model
{
    use HasFactory, Searchable;
    protected $table = "products";
    protected $primaryKey = "id";

    protected $fillable = [
        'id',
        'name',
        'category_id',
        'amount_of',
        'price',
        'content',
        'slug',
        'status'
    ];

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

    public function searchableAs()
    {
        return "products";
    }

    public function toSearchableArray()
    {
        return $this->only('name', 'slug', 'content', 'status');
    }

    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeSearchName($query, $keyword)
    {
        return $query->where('products.name', 'like', '%' . $keyword . '%')->conditionProduct();
    }

    public function scopeProductDetail($query, $slug)
    {
        return $query->where('products.slug', '=', $slug)->conditionProduct();

    }

    public function scopeDecrementProduct($query, $productId, $quantity)
    {
        return $query->find($productId)->decrement('amount_of', $quantity);
    }

    public function scopeFindName($query, $name)
    {
        return $query->where('name', $name);
    }

    public function scopeConditionProduct($query) {
        return $query->where('products.amount_of', '>', '0')
            ->where('products.status', '=', Status::ACTIVE)
            ->whereHas('categories', function ($query_categories) {
                $query_categories->where('categories.status', '=', Status::ACTIVE);
            });
    }

    public function scopeProductJoin($query)
    {
        return $query->join('categories','categories.id','=','products.category_id')->join('images','product_id','=','products.id');
    }

    public function scopeSelectProduct($query)
    {
        return $query->select('products.id as id_product','products.name as name_product','categories.name as name_category',
        'images.image','products.amount_of','products.price','products.status as status_product')
        ->where('images.STT',1);
    }

    public function scopeSelectProductByCategory($query,$id_category)
    {
        return $query->select('products.id as id_product','products.name as name_product','categories.name as name_category',
        'images.image','products.amount_of','products.price','products.status as status_product')
        ->where('products.category_id',$id_category)
        ->where('images.STT',1);
    }

    public function scopeIncrementProduct($query, $productId, $quantity)
    {
        return $query->where('id', '=', $productId)->increment('amount_of', $quantity);
    }

    public function scopeJoinOrderProductAndImage($query)
    {
        return $query->join('order_product','products.id','=','order_product.product_id')
        ->join('images','images.product_id','=','products.id');
    }

    public function scopeSelectProductOrder($query)
    {
        return $query->select('products.id as id_product','products.name','images.image','products.price',
        'order_product.amount_of as amount_of_product','order_product.total_money');
    }

    public function scopeWhereProductOrder($query,$id_order)
    {
        return $query->where('order_product.order_id',$id_order)->where('images.STT',1);
    }

    public function scopeBySubCategory($query, $categoryId)
    {
        return $query->select('products.*')
          ->join('categories', 'categories.id', '=', 'products.category_id')
          ->join('category_type', 'category_type.id', '=', 'categories.category_types_id')
          ->where('category_type.sub_id', '=', $categoryId)
          ->conditionProduct();
    }
}
