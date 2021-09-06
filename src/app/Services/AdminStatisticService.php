<?php

namespace App\Services;

use App\Models\OrderProduct;
use App\Models\TagView;
use Carbon\Carbon;

class AdminStatisticService
{
    public function filterProducts($request) {
      $dayOne = $request->findDayOne;
      $dayTwo = $request->findDayTwo;
      $order_products = OrderProduct::GetMostProducts();

      return $this->getByDayInput($order_products, $dayOne, $dayTwo);
    }

    public function filterTags($request) {
        $dayOne = $request->findDayOne;
        $dayTwo = $request->findDayTwo;
        $tag_views = TagView::countTagViews();

        return $this->getByDayInput($tag_views, $dayOne, $dayTwo);
    }

    public function filterWithWeek($model, $type) {
        $data = [];
        if ($model == 'order_products') $data = OrderProduct::GetMostProducts();
        else $data = TagView::countTagViews();

        if ($type == 'week') {
            $startOfWeek = Carbon::now()->startOfWeek();
            $endOfWeek   = Carbon::now()->endOfWeek();
            return $data->featuredInWeek($startOfWeek, $endOfWeek)->get();
        }
        if ($type == 'month') {
            $startOfMonth = Carbon::now()->startOfMonth();
            $endOfMonth   = Carbon::now()->endOfMonth();
            return $data->featuredInMonth($startOfMonth, $endOfMonth)->get();
        }

        return $data;
    }

    /**
     * Check days input and get data.
     */
    private function getByDayInput($data, $dayOne, $dayTwo) {
        if ($dayOne < $dayTwo) {
            return $data->getByBetweenDay($dayOne, $dayTwo)->get();
        }

        if ($dayOne == $dayTwo) {
            return $data->getDayNow($dayOne)->get();
        }

        return $data->get();
    }
}
