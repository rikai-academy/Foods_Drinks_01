<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use App\Exports\StatisticProductExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\TagView;
use App\Services\AdminStatisticService;
use App\Exports\StatisticTagExport;

class StatisticController extends Controller
{
    protected $adminStatisticService;

    public function __construct(AdminStatisticService $adminStatisticService)
    {
        $this->adminStatisticService = $adminStatisticService;
    }

    /**
     * Display statistic Order Products.
     *
     * @return Response
     */
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
    
    /**
     * Display statistic Tags.
     *
     * @return Response
     */
    public function statisticTags()
    {
        $tag_views = TagView::countTagViews()->get();
        return view('admin.statistic.statistic-tags', compact('tag_views'));
    }

    public function exportExcelTags($type)
    {
      return Excel::download(new StatisticTagExport($type), 'tag_views.xlsx');
    }

    /**
     * Filter days statistic Tags.
     *
     * @param Request $request
     * @return Response
     */
    public function filterTags(Request $request)
    {
        if ($request->findDayOne > $request->findDayTwo) {
            alert()->error(__('custom.Notification'), __('custom.statistic_filter_error'));
        }

        $tag_views = $this->adminStatisticService->filterTags($request);

        return view('admin.statistic.statistic-tags', compact('tag_views'));
    }

    /**
     * Filter Featured in the week statistic Order Products.
     *
     * @return Response
     */
    public function filterTheWeekOrderProducts()
    {
        $order_products = $this->adminStatisticService->filterWithWeek('order_products', 'week');
        return view('admin.statistic.index', compact('order_products'));
    }

    /**
     * Filter Featured in the month statistic Order Products.
     *
     * @return Response
     */
    public function filterTheMonthOrderProducts()
    {
        $order_products = $this->adminStatisticService->filterWithWeek('order_products', 'month');
        return view('admin.statistic.index', compact('order_products'));
    }

    /**
     * Filter Featured in the week statistic Tags.
     *
     * @return Response
     */
    public function filterTheWeekTags()
    {
        $tag_views = $this->adminStatisticService->filterWithWeek('tags', 'week');
        return view('admin.statistic.statistic-tags', compact('tag_views'));
    }

    /**
     * Filter Featured in the month statistic Tags.
     *
     * @return Response
     */
    public function filterTheMonthTags()
    {
        $tag_views = $this->adminStatisticService->filterWithWeek('tags', 'month');
        return view('admin.statistic.statistic-tags', compact('tag_views'));
    }
}
