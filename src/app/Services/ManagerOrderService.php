<?php
namespace App\Services;

use App\Models\Order;
use Mail;
use App\Jobs\AdminMailJob;

class ManagerOrderService
{
    public function getDatetime()
    {
        $previous_week = strtotime("-1 week +1 day");
        $startTime = strtotime("last monday midnight",$previous_week);
        $endTime = strtotime("next sunday midnight",$startTime);
        $startDate = date('Y-m-d 00:00:00',$startTime);
        $endDate = date('Y-m-d 23:59:59',$endTime);

        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $data['today'] = date("Y-m-d");
        $data['yesterday'] = date("Y-m-d",mktime(0, 0, 0, date("m"), (date("d") - 1), date("Y")));
        $data['start_week'] = $startDate;
        $data['end_week'] = $endDate;
        $data['this_month'] = date("Y-m");
        $data['last_month'] =  date("Y-m",mktime(0, 0, 0, (date("m") - 1), date("d"), date("Y")));

        return $data;
    }

    public function sendMailToUser($orderId, $message)
    {
        $order = Order::findById($orderId)->first();
        $email = $order->users()->first()->email;
        $order_products = $order->order_product;
        $details = [
            'title'  => __('custom.message_mail_order_confirm'),
            'body'   => $message,
            'orders' => $order_products,
            'locale' => session('website_language')
        ];
        AdminMailJob::dispatch($email, $details);
    }

}
