<?php

namespace Database\Factories;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProfileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Profile::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $users = User::pluck('id')->toArray();
        return [
            'country' => $this->faker->country,
            'description' => $this->faker->text($maxNbChars = 100),
            'image' => $this->faker->imageUrl($width = 640, $height = 480),
            'user_id' => $this->faker->randomElement($users) // or simply create new by using User::factory()
        ];
    }
}
