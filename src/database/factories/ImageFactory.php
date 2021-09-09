<?php

namespace Database\Factories;

use App\Enums\Status;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ImageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Image::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'image' => Str::random(25),
            'stt' => 1,
            'status' => Status::ACTIVE,
        ];
    }
}
