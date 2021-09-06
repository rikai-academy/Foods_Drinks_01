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

    public function scopeCountTagViews($query)
    {
        return $query->selectRaw('tag_id, COUNT(*) AS count_views, created_at, updated_at')
            ->groupBy('tag_id')
            ->orderBy('count_views', 'DESC');
    }

    public function scopeGetByBetweenDay($query, $dayOne, $dayTwo)
    {
        return $query->whereBetween('created_at', [$dayOne . ' 00:00:00', $dayTwo . ' 23:59:59']);
    }

    public function scopeGetDayNow($query, $dayOne)
    {
        return $query->where('created_at', '>=', $dayOne . ' 00:00:00');
    }

    public function scopeFeaturedInWeek($query, $dayOne, $dayTwo)
    {
        return $query->whereBetween('created_at', [$dayOne, $dayTwo]);
    }

    public function scopeFeaturedInMonth($query, $dayOne, $dayTwo)
    {
        return $query->whereBetween('created_at', [$dayOne, $dayTwo]);
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
