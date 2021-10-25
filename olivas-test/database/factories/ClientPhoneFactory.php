<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\ClientPhone;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Schema;

class ClientPhoneFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ClientPhone::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        if (!Schema::hasTable('clients'))
            die("A tabela: Clients não existe.");

        $clients = Client::get();
        if (!count($clients))
            die('Não há Clientes cadastrados.');

        return [
            'client_id' => function () {
                return Client::inRandomOrder()->first()->id;
            },
            'phone_number' => $this->faker->phoneNumber()
        ];
    }
}
