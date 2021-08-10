<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display Shopping Cart.
     *
     * @return Response
     */
    public function index()
    {
        return view('web.carts.cart');
    }

    /**
     * Add or Update Cart.
     *
     * @param Request $request
     * @return array
     */
    public function addOrUpdate(Request $request)
    {
        $product_id = $request->get('product_id');
        $action = $request->get('action');
        $cartId = $this->getCartId($product_id);
        $item = [];
        if ($cartId) {
            $item = Cart::get($cartId);
        }
        $quantity = $request->get('quantity');
        // Add to Cart
        if ($action == 'add' && $this->checkQuantity($product_id, $quantity))
        {
            $this->addProductToCart($cartId, $item, $quantity, $product_id);
        }
        // Update quantity Cart
        else if ($action == 'increment' && $this->checkQuantity($product_id, 1))
        {
            return $this->incrementProductToCart($cartId, $item);
        }
        // Update quantity Cart
        else if ($action == 'decrease')
        {
            return $this->decreaseProductToCart($cartId, $item);
        }
        else if ($action == 'delete')
        {
            $this->destroyProductToCart($cartId);
        }

        return array('count' => Cart::count(), 'subtotal' => Cart::subtotal());
    }

    /** Add Products to Cart */
    private function addProductToCart($cartId, $item, $quantity, $productId) {
        if ($cartId && $quantity > 1) { // Update in Product detail
            Cart::update($cartId, $item->qty + $quantity);
            $this->checkQuantity($productId, $item->qty);
        } else if ($cartId) { // Update when cart exists
            Cart::update($cartId, $item->qty + 1);
        } else {
            $product = Product::find($productId);
            Cart::add($productId, $product->name, $quantity, $product->price, [
                'slug' => $product->slug,
                'quantity' => $product->amount_of, 'image' => $product->images->first()->image,
            ]);
        }
    }

    /** Increment Products to Cart */
    private function incrementProductToCart($cartId, $item) {
        Cart::update($cartId, $item->qty + 1);
        return array('qty' => $item->qty, 'price' => ($item->qty * $item->price),
            'count' => Cart::count(), 'subtotal' => Cart::subtotal()
        );
    }

    /** Decrease Products to Cart */
    private function decreaseProductToCart($cartId, $item) {
        if ($item->qty <= 1) {
            return array(
                'qty' => $item->qty, 'price' => $item->price, 'count' => Cart::count(),
                'subtotal' => Cart::subtotal(),
            );
        }
        Cart::update($cartId, $item->qty - 1);
        return array(
            'qty' => $item->qty, 'price' => ($item->qty * $item->price), 'count' => Cart::count(),
            'subtotal' => Cart::subtotal(),
        );
    }

    /** Destroy Products to Cart */
    private function destroyProductToCart($cartId) {
        Cart::remove($cartId);
    }

    /**
     * Destroy Cart.
     */
    public function destroy()
    {
        Cart::destroy();
        return redirect()->route('cart');
    }

    /**
     * Get Cart Id.
     *
     * @param $product_id
     * @return boolean
     */
    private function getCartId($product_id)
    {
        $rowId = Cart::content()->search(function ($cartItem) use ($product_id) {
            return $cartItem->id == $product_id;
        });
        return $rowId;
    }

    /**
     * Check quantity of Cart and Product when add or update.
     */
    private function checkQuantity($productId, $qty)
    {
        $qtyProduct = Product::find($productId)->amount_of;
        $cart = $this->getCartId($productId);
        $qtyCart = 0;
        if ($cart) {
            $qtyCart = Cart::get($cart)->qty;
        }
        $sum = $qty + $qtyCart;
        if ($sum > $qtyProduct) {
            return false;
        }
        return true;
    }
}
