<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Categories;
use App\Models\CategoryType;

class CategoriesSeeder extends Seeder
{
    public function run()
    {
      $limit = 15; // Number of columns created
      for ($i = 0; $i < $limit; $i++) {
        $name = Str::random(10);
        $slug = Str::slug($name);
        Categories::create([
          'name'              => $name,
          'slug'              => $slug,
          'status'            => 1,
          'category_types_id' => CategoryType::all()->random()->id,
        ]);
      }
    }
}
