<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use App\Exports\StatisticProductExport;
use Maatwebsite\Excel\Facades\Excel;

class StatisticController extends Controller
{
    public function index()
    {
        $order_products = OrderProduct::GetMostProducts()->get();
        return view('admin.statistic.index', compact('order_products'));
    }

    public function filterProducts(Request $request)
    {
        $order_products = OrderProduct::GetMostProducts();
        $dayOne = $request->findDayOne;
        $dayTwo = $request->findDayTwo;
        if ($dayOne < $dayTwo) {
            $order_products = $order_products->getByBetweenDay($dayOne, $dayTwo)->get();
        }
        else if ($dayOne == $dayTwo) {
            $order_products = $order_products->getDayNow()->get();
        }
        else {
            $order_products = $order_products->get();
            alert()->error(__('custom.Notification'), __('custom.statistic_filter_error'));
        }

      return view('admin.statistic.index', compact('order_products'));
    }

    public function exportExcel($type)
    {
        return Excel::download(new StatisticProductExport($type), 'order_products.xlsx');
    }
}
