<?php

namespace App\Services;

use App\Enums\Status;
use DB;
use Cart;
use App\Models\Product;

class OrderService {

    /**
     * Insert Products to Orders.
     *
     * @param $userId
     * @param $totalAllCarts
     * @return bool
     */
    public function create($userId, $totalAllCarts)
    {
        # Init actions
        DB::beginTransaction();
        try {
            # Get timestamps now
            $timestamps = \Carbon\Carbon::now();
            # Insert Orders to DB
            $idOrders = DB::table('orders')->insertGetId([
                'user_id'     => $userId,
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
            return $idOrders;
        } catch (Exception $e) {
            # Got some error to rollback
            DB::rollBack();
            return false;
        }
    }

    # Format Price
    private function replacePrice($price)
    {
        $strPrice = str_replace(',', '', $price);
        return (float)$strPrice;
    }
}
