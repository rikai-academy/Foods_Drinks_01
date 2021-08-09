<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ImageSeeder extends Seeder
{
    public function run()
    {
        $images = ['7up.jpg','coca_cola.jpg','fanta.jpg','pepsi.jpg','product.jpg','banh-mi-tuoi.jpg','trung.jpg'];
        $products = Product::all();

        foreach ($products as $product) {
            for ($i = 0; $i < 3; $i++) {
                Image::create([
                    'image' => $images[array_rand($images)],
                    'status' => 1,
                    'product_id' => $product->id,
                ]);
            }
        }
    }
}
