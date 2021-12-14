<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => 'Pessoa'
        ];
    }

    /**
     * Indicate that the user is a Legal Person
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function cpf()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Pessoa Física',
            ];
        });
    }

    /**
     * Indicate that the user is a Natural Person
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function cnpj()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Pessoa Jurídica ',
            ];
        });
    }
}
