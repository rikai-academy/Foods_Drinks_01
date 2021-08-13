<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;

    protected $table = "categories";
    protected $primaryKey = "id";

    protected $fillable = [
        'name',
        'category_types_id',
        'slug',
        'status'
    ];
    protected $guarded = [];

    public function products()
    {
        return $this->hasMany(Product::class,'category_id');
    }

    public function category_type()
    {
        return $this->belongsTo(CategoryType::class,'category_types_id');
    }

    public function scopeCategoryType($query, $category_types)
    {
        return $query->where('category_types_id', $category_types)->orderBy('name');
    }
    public function scopeSlug($query, $slug) {
        return $query->where('slug', $slug);
    }

    public function scopeWhereNameCategory($query, $name) {
        return $query->where('name',$name);
    }

    public function scopeWhereCategoryType($query, $id_category_type) {
        return $query->where('category_types_id',$id_category_type);
    }

    public function scopeWhereUpdateCategory($query, $id_category,$name) {
        return $query->where([['id','!=',$id_category],['name','=',$name]]);
    }
}
