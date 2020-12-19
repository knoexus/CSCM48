<?php

namespace Database\Factories;

use App\Models\Notification;
use App\Models\User;
use App\Models\Journey;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotificationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Notification::class;

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
            'type' => $this->faker->randomElement(['like', 'comment']),
            'is_read' => $this->faker->boolean,
            'sender_id' => $this->faker->randomElement($users), // or simply create new by using User::factory(),
            'recipient_id' => $this->faker->randomElement($users), // or simply create new by using User::factory(),
            'journey_id' => $this->faker->randomElement($journeys) // or simply create new by using Journey::factory()
        ];
    }
}
