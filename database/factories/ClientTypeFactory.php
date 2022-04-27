<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ClientTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'description' => $this->faker->randomElement(['Pessoa Física', 'Pessoa Jurídica'])
        ];
    }
}
