<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\Status;

class Tag extends Model
{
    use HasFactory;

    protected $table = "tags";
    protected $primaryKey = "id";

    protected $fillable = [
        'id','name','slug','number_of_search','status'
    ];

    protected $guarded = [];

    public function product_tag()
    {
        return $this->hasMany(Product_Tag::class,'tag_id');
    }

    public function scopeSlug($query, $slug) {
        return $query->where('slug', $slug);
    }

    public function scopeStatusTag($query)
    {
        return $query->where('status', '=', Status::ACTIVE)->inRandomOrder()->limit(5);
    }
}
