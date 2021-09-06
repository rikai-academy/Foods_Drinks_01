<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTag extends Model
{
    use HasFactory;

    public $table = "product_tag";

    public function tags()
    {
      return $this->belongsTo(Tag::class, 'tag_id');
    }

    public function scopeGetTagsByProduct($query, $productId)
    {
      return $query->where('product_id', '=', $productId);
    }

    public function scopeGetCount($query)
    {
        return $query->selectRaw('tag_id, COUNT(*) AS count_tags')
            ->groupBy('tag_id')
            ->orderBy('count_tags', 'DESC')
            ->limit(12);
    }
}
