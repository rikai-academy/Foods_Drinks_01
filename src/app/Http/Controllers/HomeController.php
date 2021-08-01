<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Models AS Model;

class HomeController extends Controller
{
    public function index(){
        // Show Posts in Home page
        $latest_products = Model\Product::status(Status::ACTIVE)->orderBy('created_at', 'desc')->take(9)->get();
        $product_recommends = Model\Product::status(Status::ACTIVE)->inRandomOrder()->take(18)->get();

        return view('home')
          ->with([
            'latest_products'    => $latest_products,
            'recommend_products' => $product_recommends->chunk(3),
          ]);
    }
}
