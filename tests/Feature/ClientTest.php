<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\ClientType;
use App\Models\Phone;
use App\Models\Seller;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Traits\SignIn;

class ClientTest extends TestCase
{
    use RefreshDatabase, WithFaker, SignIn;

    protected $clientJsonStructure = [
        'id',
        'name',
        'email',
        'type',
        'phones' => [
            '*' => [
                'id',
                'number',
            ],
        ],
        'sellers' => [
            '*' => [
                'id',
                'name',
                'email',
            ],
        ],
    ];

    public function test_should_get_all_clients()
    {
        $this->signIn();

        Client::factory()
            ->count(2)
            ->has(Phone::factory()->count(2))
            ->has(Seller::factory()->count(2))
            ->create();

        $response = $this->getJson(route('clients.index'));

        $response
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => $this->clientJsonStructure,
                ],
            ]);
    }

    public function test_calling_clients_should_get_an_error_if_unauthenticated() {
        $response = $this->getJson(route('clients.index'));

        $response->assertUnauthorized();
    }

    public function test_should_get_a_specific_client()
    {
        $this->signIn();

        $client = Client::factory()
                        ->has(Seller::factory()->count(2))
                        ->has(Phone::factory()->count(2))
                        ->create();

        $response = $this->getJson(route('clients.show', $client));

        $response
            ->assertOk()
            ->assertJsonStructure([
                'data' => $this->clientJsonStructure,
            ]);
    }

    public function test_calling_a_specific_client_should_get_an_error_if_unauthenticated() {
        $client = Client::factory()->create();

        $response = $this->getJson(route('clients.show', $client));

        $response->assertUnauthorized();
    }

    public function test_should_create_a_client_with_valid_fields()
    {
        $this->signIn();

        $clientType = ClientType::factory()->create();

        $data = [
            'name' => $this->faker->name(),
            'email' => $this->faker->email,
            'client_type_id' => $clientType->id,
            'phones' => [
                ['number' => $this->faker->phoneNumber],
                ['number' => $this->faker->phoneNumber],
            ],
            'sellers' => [
                ['id' => Seller::factory()->create()->id],
                ['id' => Seller::factory()->create()->id],
            ]
        ];

        $response = $this->postJson(route('clients.store'), $data);

        $response
            ->assertValid()
            ->assertCreated()
            ->assertJsonStructure([
                'data' => $this->clientJsonStructure,
            ]);
    }

    public function test_should_get_an_error_creating_client_if_fields_are_invalid()
    {
        $this->signIn();

        $clientType = ClientType::factory()->create();

        $data = [
            'name' => $this->faker->name(),
            'email' => $this->faker->email,
            'client_type_id' => $clientType->id,
            'phones' => [],
            'sellers' => [
                ['id' => 0],
            ]
        ];

        $response = $this->postJson(route('clients.store'), $data);

        $response
            ->assertInvalid(['phones', 'sellers.0.id'])
            ->assertUnprocessable();
    }

    public function test_should_get_an_error_creating_client_if_unauthenticated()
    {
        $response = $this->postJson(route('clients.store'), []);

        $response
            ->assertUnauthorized();
    }

    public function test_should_update_a_client_with_valid_fields()
    {
        $this->signIn();

        $client = Client::factory()
            ->has(Phone::factory())
            ->has(Seller::factory())
            ->create();

        $data = [
            'phones' => [
                ['number' => $this->faker->phoneNumber],
                ['number' => $this->faker->phoneNumber],
            ],
            'sellers' => [
                ['id' => Seller::factory()->create()->id],
                ['id' => Seller::factory()->create()->id],
            ]
        ];

        $response = $this->putJson(route('clients.update', $client), $data);

        $response
            ->assertValid()
            ->assertOk()
            ->assertJsonStructure([
                'data' => $this->clientJsonStructure,
            ]);
    }

    public function test_should_get_an_error_updating_client_if_fields_are_invalid()
    {
        $this->signIn();

        $client = Client::factory()->create();

        $data = [
            'email' => 'kevin',
            'sellers' => [
                ['id' => 0],
            ]
        ];

        $response = $this->putJson(route('clients.update', $client), $data);

        $response
            ->assertInvalid(['email', 'sellers.0.id'])
            ->assertUnprocessable();
    }

    public function test_should_get_an_error_updating_client_if_unauthenticated()
    {
        $client = Client::factory()->create();

        $response = $this->putJson(route('clients.update', $client), []);

        $response->assertUnauthorized();
    }

    public function test_it_soft_deletes_a_client()
    {
        $this->signIn();

        $client = Client::factory()->create();

        $response = $this->deleteJson(route('clients.destroy', $client));

        $response->assertNoContent();

        $this->assertSoftDeleted($client);
    }

    public function test_calling_client_gets_an_error_if_deleted()
    {
        $this->signIn();

        $client = Client::factory()->create();

        $client->delete();

        $response = $this->getJson(route('clients.show', $client));

        $response->assertNotFound();
    }

    public function test_delete_client_gets_an_error_if_unauthenticated()
    {
        $client = Client::factory()->create();

        $response = $this->deleteJson(route('clients.destroy', $client));

        $response->assertUnauthorized();
    }
}
