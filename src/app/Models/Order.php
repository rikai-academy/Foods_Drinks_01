<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = "orders";
    protected $primaryKey = "id";
    protected $guarded = [];

    public function users()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function order_product()
    {
        return $this->hasMany(OrderProduct::class,'order_id');
    }

    public function scopeByUserId($query, $userId)
    {
        return $query->where('user_id', $userId)->orderBy('created_at', 'DESC');
    }

    public function scopeFindById($query, $id)
    {
        return $query->find($id);
    }
}
