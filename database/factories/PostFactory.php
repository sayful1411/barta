<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => fake()->uuid(),
            'description' => fake()->paragraph(5),
            'views_count' => fake()->numerify()
        ];
    }

    public function with_user(): Factory
    {
        return $this->state(function (array $attributes) {
            $userId = User::inRandomOrder()->first()->id;

            return [
                'user_id' => $userId,
            ];
        });
    }

}
