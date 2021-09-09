<?php

namespace Database\Factories;

use App\Enums\Status;
use App\Models\Categories;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => Str::random(15),
            'category_id' => Categories::first()->id,
            'amount_of' => $this->faker->randomDigit,
            'price' => $this->faker->randomDigit,
            'content' => Str::random(50),
            'slug' => Str::slug(Str::random(15)),
            'status' => Status::ACTIVE,
        ];
    }
}
