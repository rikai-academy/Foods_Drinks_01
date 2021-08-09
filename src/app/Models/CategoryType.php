<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryType extends Model
{
    use HasFactory;
    protected $table = "category_type";
    protected $primaryKey = "id";
    protected $guarded = [];

    public function categories()
    {
        return $this->hasMany(Categories::class,'category_types_id');
    }

    public function products()
    {
      return $this->hasManyThrough(
        Product::class,Categories::class,'category_types_id','category_id'
        );
    }
    public function scopeSlug($query, $slug) {
        return $query->where('slug', $slug);
    }
}
