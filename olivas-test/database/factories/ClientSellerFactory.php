<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\ClientSeller;
use App\Models\Seller;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ClientSellerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ClientSeller::class;

    public function generate($generateNumber)
    {
        for ($i = 0; $i < $generateNumber; $i++)
            ClientSeller::factory(1)->create();
    }

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $tableClientsAndSellers = !Schema::hasTable('clients') || !Schema::hasTable('sellers');
        if ($tableClientsAndSellers)
            die("As tabelas: clients e sellers não existem.");

        $sellers = Seller::get();
        if (!count($sellers))
            die('Não há vendedores cadastrados.');

        $clients = Client::get();
        if (!count($clients)) die('Não há Clientes cadastrados.');

        $clientQueryId = DB::select('SELECT id FROM clients WHERE id NOT IN (SELECT client_id FROM client_sellers)');

        $clientId = count($clientQueryId) ? $clientQueryId[0]->id : false;
        if (!$clientId) return die('Todos clientes já receberam um vendedor.');

        return [
            'client_id' => $clientId,
            'seller_id' => function () {
                return Seller::inRandomOrder()->first()->id;
            }
        ];
    }
}
