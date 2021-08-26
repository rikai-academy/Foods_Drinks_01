<?php

namespace App\Services;

use App\Enums\Status;
use App\Enums\UserRole;
use App\Jobs\AdminMailJob;
use App\Models\Order;
use App\Models\User;
use DB;
use Cart;
use App\Models\Product;
use wataridori\ChatworkSDK\ChatworkRoom;
use wataridori\ChatworkSDK\ChatworkSDK;

class OrderService {

    /**
     * Insert Products to Orders.
     *
     * @param $user
     * @return bool
     */
    public function create($user)
    {
        $idOrders = 0;
        
        # Init actions
        DB::beginTransaction();
        try {
            # Get timestamps now
            $timestamps = \Carbon\Carbon::now();

            # Get Total all carts
            $totalAllCarts = $this->replacePrice(Cart::subtotal());

            # Insert Orders to DB
            $idOrders = DB::table('orders')->insertGetId([
                'user_id'     => $user->id,
                'total_money' => $totalAllCarts,
                'status'      => Status::BLOCK,
                "created_at"  => $timestamps,
                "updated_at"  => $timestamps,
            ]);

            # Get Products in Cart
            $products = Cart::content();

            # Insert Order Products to DB
            foreach ($products as $product) {
                $totalProduct = $this->replacePrice($product->subtotal());

                # Insert Product to Order Product
                DB::table('order_product')->insert([
                    'product_id'  => $product->id,
                    'amount_of'   => $product->qty,
                    'total_money' => $totalProduct,
                    'order_id'    => $idOrders,
                    "created_at"  => $timestamps,
                    "updated_at"  => $timestamps,
                ]);

                # Update quantity of Product
                Product::decrementProduct($product->id, $product->qty);
            }

            # Commit data pass
            DB::commit();
        } catch (Exception $e) {
            # Got some error to rollback
            DB::rollBack();
            return false;
        }

        # Get Orders last insert
        $order = Order::findById($idOrders);
        $total = formatPrice($totalAllCarts);
        $order_products = $order->order_product;

        # Get Message Send mail and send Chatwork
        $message = $this->getMessage($user->name, $idOrders, $total, $order->created_at);

        # Send mail to Admin
        $this->sendMail($message, $order_products);

        # Sent message to Chatwork
        $this->sendMessageToChatwork($message);

        # Destroy Carts
        Cart::destroy();

        return $idOrders;
    }

    # Format Price
    private function replacePrice($price)
    {
        $strPrice = str_replace(',', '', $price);
        return (float)$strPrice;
    }

    /**
     * Cancel Order and add quantity to Products.
     *
     * @param $orderId
     * @return array
     */
    public function cancelOrder($orderId)
    {
        DB::beginTransaction();
        try {
            # Update status
            Order::updateStatus($orderId, Status::CANCEL);

            # Add quantity to Products
            $order_products = Order::findById($orderId)->order_product;
            foreach ($order_products as $product) {
                Product::incrementProduct($product->product_id, $product->amount_of);
            }

            DB::commit();
            return array(
                'alert'   => 'alert-success',
                'message' => __('custom.message_cancel_order_success'),
            );
        } catch (Exception $e) {
            DB::rollBack();
            return array(
                'alert'   => 'alert-danger',
                'message' => __('custom.message_order_error_db'),
            );
        }
    }

    # Send message to Chatwork when user order.
    private function sendMessageToChatwork ($message)
    {
        ChatworkSDK::setApiKey(config('app.apiKeyChatwork'));
        $room = new ChatworkRoom(config('app.roomIdChatwork'));
        $room->sendMessageToAll($message, true);
    }

    /**
     * Send mail to all Admin.
     *
     * @param $message
     * @param $order_products
     */
    private function sendMail($message, $order_products) {
        $emailOfAdmin = User::byRole(UserRole::getKey(0))->first()->email;
        $details = [
            'title'  => __('custom.mail_order'),
            'body'   => $message,
            'orders' => $order_products,
            'locale' => session('website_language'),
          ];

        AdminMailJob::dispatch($emailOfAdmin, $details);
    }

    # Get message.
    private function getMessage($name, $idOrders, $totalAmount, $created_at) {
        $date = checkLanguageWithDay($created_at);
        $message_en = "$name has ordered product: Order Id is $idOrders. Total amount is $totalAmount. At $date.";
        $message_vi = "$name đã đặt sản phẩm: Mã đơn hàng là $idOrders. Tổng số tiền là $totalAmount. Lúc $date.";
        return checkLanguage($message_en, $message_vi);
    }
}
