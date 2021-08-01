<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;
    protected $table = "categories";
    protected $primaryKey = "id";
    protected $guarded = [];

    public function products()
    {
        return $this->hasMany(Product::class,'category_id');
    }

    public function category_type()
    {
        return $this->belongsTo(CategoryType::class,'category_types_id');
    }
}