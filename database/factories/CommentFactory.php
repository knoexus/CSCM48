<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\User;
use App\Models\Journey;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $users = User::pluck('id')->toArray();
        $journeys = Journey::pluck('id')->toArray();
        return [
            'body' => $this->faker->text($maxNbChars = 100),
            'user_id' => $this->faker->randomElement($users), // or simply create new by using User::factory(),
            'journey_id' => $this->faker->randomElement($journeys) // or simply create new by using Journey::factory()
        ];
    }
}
