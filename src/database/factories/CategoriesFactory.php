<?php

namespace Database\Factories;

use App\Enums\Status;
use App\Models\Categories;
use App\Models\CategoryType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoriesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Categories::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => Str::random(15),
            'category_types_id' => CategoryType::first()->id,
            'slug' => Str::slug(Str::random(15)),
            'status' => Status::ACTIVE,
        ];
    }
}
