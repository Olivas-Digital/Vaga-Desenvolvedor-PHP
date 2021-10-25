<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\ClientType;
use App\Models\DocumentType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ClientTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ClientType::class;


    public function generate($generateNumber)
    {
        for ($i = 0; $i < $generateNumber; $i++)
            ClientType::factory(1)->create();
    }

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $tableClientsAndDocuments = !Schema::hasTable('clients') || !Schema::hasTable('document_types');
        if ($tableClientsAndDocuments)
            die("As tabelas: clients e document_types não existem.");

        $documents = DocumentType::get();
        if (!count($documents))
            die('Não há tipos de documentos cadastrados.');

        $clients = Client::get();
        if (!count($clients)) die('Não há Clientes cadastrados.');

        $clientQueryId = DB::select('SELECT id FROM clients WHERE id NOT IN (SELECT client_id FROM client_types)');

        $clientId = count($clientQueryId) ? $clientQueryId[0]->id : false;
        if (!$clientId) return die('Todos clientes já receberam um tipo de documento.');

        return [
            'client_id' => $clientId,
            'client_type' => function () {
                return DocumentType::inRandomOrder()->first()->id;
            }
        ];
    }
}
