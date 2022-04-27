<?php

namespace Database\Factories;

use App\Models\ClientType;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->email,
            'client_type_id' => ClientType::factory(),
        ];
    }
}
