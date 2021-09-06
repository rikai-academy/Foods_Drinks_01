<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'en_name', 'vi_name'];

    public function products()
    {
        return $this->belongsToMany(Product ::class, 'product_tag', 'tag_id', 'product_id');
    }

    public function product_tags ()
    {
        return $this->hasMany(ProductTag::class, 'tag_id');
    }

    public function tag_views ()
    {
        return $this->hasMany(TagView::class, 'tag_id');
    }

    public function scopeFindById($query, $id)
    {
        return $query->find($id);
    }

    public function scopeFindBySlug($query, $slug)
    {
        return $query->where('slug', '=', $slug);
    }

    public function scopeUpdateTag($query, $id, $tag)
    {
        return $query->where('id', '=', $id)->update($tag);
    }

    public function scopeGetByBetweenDay($query, $dayOne, $dayTwo)
    {
        return $query->whereBetween('created_at', [$dayOne, $dayTwo]);
    }

    public function scopeGetDayNow($query)
    {
        return $query->where('created_at', '>=', date('Y-m-d').' 00:00:00');
    }

    public function scopeGetThisYear($query)
    {
        return $query->whereYear('created_at', date("Y"));
    }

    public function scopeGetThisMonth($query)
    {
        return $query->whereMonth('created_at', date("m"));
    }
}
