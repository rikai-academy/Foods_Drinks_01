<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

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

    public function scopeByMonthYear($query, $month, $year)
    {
        return $query->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month);
    }

    public function scopeTotalAllPrice($query)
    {
         return $query->sum('total_money');
    }

    public function scopeTop5UsersOrdered($query)
    {
        return $query->groupBy('user_id')
            ->select('user_id', DB::raw('count(*) as number_ordered'), DB::raw('sum(total_money) as total_money'))
            ->orderBy('total_money')
            ->take(5);
    }

    public function scopeUpdateStatus($query, $orderId, $status)
    {
        return $query->findById($orderId)->update(['status' =>  $status]);
    }
}
