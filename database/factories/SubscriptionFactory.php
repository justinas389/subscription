<?php

namespace Database\Factories;

use App\Models\User;
use App\States\Trial;
use App\States\Active;
use App\States\Canceled;
use App\States\Suspended;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubscriptionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'phase' => $this->faker->randomElement([Trial::class, Active::class, Suspended::class, Canceled::class]),
            'start_date' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'end_date' => $this->faker->dateTimeBetween('now', '+1 month'),
            'price' => $this->faker->randomFloat(2, 5, 100),
        ];
    }
}
