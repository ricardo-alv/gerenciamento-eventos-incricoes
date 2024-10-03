<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->sentence(3), 
            'url' => Str::slug($this->faker->unique()->sentence(3)), 
            'description' => $this->faker->optional()->paragraph, 
            'location' => $this->faker->address, 
            'start_date' => $this->faker->dateTimeBetween('now', '+1 year'),
            'end_date' => $this->faker->dateTimeBetween('+1 day', '+1 year'), 
            'capacity' => $this->faker->numberBetween(50, 500), 
            'category_id' => \App\Models\Category::factory(), 
            'user_id' => \App\Models\User::factory(), 
        ];
    }
}
