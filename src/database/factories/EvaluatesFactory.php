<?php

namespace Database\Factories;

use App\Models\Evaluates;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class EvaluatesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Evaluates::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'review' => Str::random(25),
            'rating' => 5,
            'user_id' => User::first()->id,
        ];
    }
}
