<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Registration>
 */
class RegistrationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'event_id' => Event::factory(), // Cria um evento se não existir
            'user_id' => User::factory(), // Cria um usuário se não existir
            'participant_name' => $this->faker->name(), // Nome fictício do participante
            'participant_email' => $this->faker->unique()->safeEmail(), // E-mail fictício
        ];
    }
}
