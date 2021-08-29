<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderProduct;
use App\Services\ManagerOrderService;
use DB;

class ManagerStatisticController extends Controller
{
    public function statisticProduct(ManagerOrderService $managerOrderService)
    {
        $datetime = $managerOrderService->getDatetime();
        $statistic_products = OrderProduct::OrderProductJoin()
        ->WhereStatisticProduct($datetime['today'])
        ->SelectStatisticProduct()
        ->groupBy('order_product.product_id')
        ->orderBy('amount_of_order','desc')
        ->get();
        
        return view('admin.statistic.statistic-product',$datetime,compact('statistic_products'));
    }

    public function statisticProductSearchTime($time)
    {
        $data = OrderProduct::OrderProductJoin()
        ->WhereStatisticProduct($time)
        ->SelectStatisticProduct()
        ->groupBy('order_product.product_id')
        ->orderBy('amount_of_order','desc')
        ->get();

        return json_encode($data);
    }

    public function statisticProductLastWeek(Request $request)
    {
        $data = OrderProduct::OrderProductJoin()
        ->LastWeek($request->start_week,$request->end_week)
        ->SelectStatisticProduct()
        ->groupBy('order_product.product_id')
        ->orderBy('amount_of_order','desc')
        ->get();

        return json_encode($data);
    }
}