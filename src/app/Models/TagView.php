<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagView extends Model
{
    use HasFactory;

    protected $fillable = ['tag_id'];

    public function tags()
    {
        return $this->belongsTo(Tag::class, 'tag_id');
    }
}
