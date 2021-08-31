<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        # Statistic Users
        $countUsers = User::getCountUsers()->pluck('count_users');
        $countUserMonths = User::getCountMonth()->pluck('month');
        $valueUserOfMonths = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        foreach ($countUserMonths as $index => $month) {
            $valueUserOfMonths[$month - 1] = $countUsers[$index];
        }

        # Statistic Orders
        $countOrders = Order::getCountOrders()->pluck('count_orders');
        $countOrderMonths = Order::getCountMonth()->pluck('month');
        $valueOrderOfMonths = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        foreach ($countOrderMonths as $index => $month) {
            $valueOrderOfMonths[$month - 1] = $countOrders[$index];
        }

        return view('admin.index', compact('valueUserOfMonths', 'valueOrderOfMonths'));
    }

    public function notify() {
        return view('admin.notify.index');
    }
    
    public function maskNotify(Request $request) {

        auth()->user()
            ->unreadNotifications
            ->when($request->id, function ($query) use ($request) {
                return $query->where('id', $request->id);
            })
            ->markAsRead();

        return response()->noContent();
    }
}
