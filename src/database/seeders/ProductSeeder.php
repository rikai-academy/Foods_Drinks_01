<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Categories;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
      $limit = 50; // Number of columns created
      for ($i = 0; $i < $limit; $i++) {
        $name = Str::random(20);
        $slug = Str::slug($name);
        Product::create([
          'name'        => $name,
          'slug'        => $slug,
          'status'      => 1,
          'content'     => Str::random(50),
          'amount_of'   => rand(1, 20),
          'price'       => rand(1000, 500000),
          'category_id' => Categories::all()->random()->id,
        ]);
      }
    }
}
