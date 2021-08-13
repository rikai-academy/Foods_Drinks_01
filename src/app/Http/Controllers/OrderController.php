<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Cart;
use Illuminate\Support\Facades\Auth;
use wataridori\ChatworkSDK\ChatworkRoom;
use wataridori\ChatworkSDK\ChatworkSDK;
use App\Services\OrderService;

class OrderController extends Controller
{
    protected $orderService;

    /**
     * Instantiate a new Order service instance.
     *
     * @param OrderService $orderService
     */
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

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
            # Get Id User login, Total all carts
            $userId = $user->id;
            $totalAllCarts = $this->replacePrice(Cart::subtotal());
            # Insert Orders to DB
            $orderId = $this->orderService->create($userId, $totalAllCarts);
            # Check error when insert data
            if (empty($orderId)) {
                return redirect()->route('cart')->with([
                    'message' => __('custom.message_order_error_db'),
                    'alert' => 'alert-danger',
                ]);
            }
            # Get Orders last insert
            $order = Order::findById($orderId)->first();
            $create_at = date_format($order->created_at, 'M d, Y h:i A');
            $total = formatPrice($totalAllCarts);
            # Sent message to Chatwork
            $this->sendMessageToChatwork($user->name, $orderId, $total, $create_at);
            # Destroy Carts
            Cart::destroy();

            return redirect('/profile#tab2primary')->with([
                'message' => __('custom.message_order_success'),
                'alert' => 'alert-success',
            ]);

        }
        abort(404);
    }

    # Format Price
    private function replacePrice($price)
    {
      $strPrice = str_replace(',', '', $price);
      return (float)$strPrice;
    }

    # Send message to Chatwork when user order.
    private function sendMessageToChatwork ($name, $idOrders, $totalAmount, $created)
    {
        ChatworkSDK::setApiKey(config('app.apiKeyChatwork'));
        $room = new ChatworkRoom(config('app.roomIdChatwork'));
        $message = "$name has ordered product: Order Id is $idOrders. Total amount is $totalAmount. At $created.";
        $room->sendMessageToAll($message, true);
    }
}
