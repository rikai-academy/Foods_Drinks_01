<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Models\Product;

class HomeController extends Controller
{
    public function index(){
        // Show Posts in Home page
        $latest_products = Product::conditionProduct()->orderBy('created_at', 'desc')->take(9)->get();
        $product_recommends = Product::conditionProduct()->inRandomOrder()->take(18)->get();

        return view('home')
          ->with([
            'latest_products'    => $latest_products,
            'recommend_products' => $product_recommends->chunk(3),
          ]);
    }
}
