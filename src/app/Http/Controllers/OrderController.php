<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderProduct;
use Cart;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Insert Products when order.
     *
     * @return Response
     */
    public function orderProduct ()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if (empty($user->phone) || empty($user->address)) {
                return redirect('profile')->with([
                  'message' => __('custom.message_profile_update_information'),
                  'alert' => 'alert-danger',
                ]);
            }
            $userId = $user->id;
            $total = $this->replacePrice(Cart::subtotal());
            // Insert Order
            $order = $this->createOrders($userId, $total);
            if (!$order) {
                return abort(500, 'Error');
            }
            $carts = Cart::content();
            $orderId = $order->id;
            // Insert Product Order
            foreach ($carts as $cart) {
                $totalCart = $this->replacePrice($cart->subtotal());
                $orderProduct = $this->createOrderProduct($orderId, $cart, $totalCart);
                if (!$orderProduct) {
                    Order::destroy($orderId);
                    return abort(500, 'Error');
                }
            }
            Cart::destroy(); // Destroy Cart
            toast(__('custom.message_order_success'),'success');
            return redirect('/profile#tab2primary')->with([
                'message' => __('custom.message_order_success'),
                'alert' => 'alert-success',
            ]);

        }
        abort(404);
    }

    /**
     * Insert data in Orders
     *
     * @param $userId
     * @param $total
     * @return array
     */
    private function createOrders($userId, $total)
    {
        return Order::create([
            'user_id'     => $userId,
            'total_money' => $total,
            'status'      => 1,
        ]);
    }

    /**
     * Insert data in Order Product
     *
     * @param $orderId
     * @param $cart
     * @param $totalCart
     * @return array
     */
    private function createOrderProduct($orderId, $cart, $totalCart)
    {
        return OrderProduct::create([
            'product_id'  => $cart->id,
            'amount_of'   => $cart->qty,
            'total_money' => $totalCart,
            'order_id'    => $orderId,
        ]);
    }

    # Format Price
    private function replacePrice($price) {
        $strPrice = str_replace(',', '', $price);
        return (float)$strPrice;
    }
}
