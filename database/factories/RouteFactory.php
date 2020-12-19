<?php

namespace Database\Factories;

use App\Models\Route;
use App\Models\Journey;
use Illuminate\Database\Eloquent\Factories\Factory;

class RouteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Route::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $journeys = Journey::pluck('id')->toArray();
        return [
            'order' => $this->faker->numberBetween($min = 1, $max = 10),
            'start_lat' => $this->faker->latitude($min = -90, $max = 90),
            'start_lon' => $this->faker->longitude($min = -180, $max = 180),
            'finish_lat' => $this->faker->latitude($min = -90, $max = 90),
            'finish_lon' => $this->faker->longitude($min = -180, $max = 180),
            'distance_km' => $this->faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 1000000),
            'length_min' => $this->faker->numberBetween($min = 10, $max = 1000000),
            'journey_id' => $this->faker->randomElement($journeys) // or simply create new by using Journey::factory()
        ];
    }
}
