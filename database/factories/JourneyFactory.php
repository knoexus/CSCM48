<?php

namespace Database\Factories;

use App\Models\Journey;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class JourneyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Journey::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $users = User::pluck('id')->toArray();
        return [
            'title' => $this->faker->text($maxNbChars = 100),
            'image' => $this->faker->imageUrl($width = 640, $height = 480),
            'difficulty' => $this->faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 10),
            'enjoyability' => $this->faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 10),
            'would_recommend' => $this->faker->boolean($chanceOfGettingTrue = 50),
            'description' => $this->faker->text($maxNbChars = 240),
            'user_id' => $this->faker->randomElement($users) // or simply create new by using User::factory()
        ];
    }
}
