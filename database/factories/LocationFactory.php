<?php

namespace Database\Factories;

use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

class LocationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Location::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->company,
            'description' => $this->faker->text,
            'user_id' => \App\Models\User::inRandomOrder()->first()->id,
            'longitude' => $this->faker->randomFloat($nbMaxDecimals = 2, $min = 16, $max = 23),
            'latitude' => $this->faker->randomFloat($nbMaxDecimals = 2, $min = 50, $max = 54),
        ];
    }
}
