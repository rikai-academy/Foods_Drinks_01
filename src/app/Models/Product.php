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

    public function scopeConditionProduct($query) {
        return $query->where('products.amount_of', '>', '0')->where('products.status', '=', Status::ACTIVE);
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
}
