<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Seller;
use App\Models\Phone;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Traits\SignIn;

class SellerTest extends TestCase
{
    use RefreshDatabase, WithFaker, SignIn;

    protected $sellerJsonStructure = [
        'id',
        'name',
        'email',
        'clients' => [
            '*' => [
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
            ],
        ],
    ];

    public function test_should_get_all_sellers()
    {
        $this->signIn();

        Seller::factory()
            ->count(2)
            ->has(
                Client::factory()
                    ->count(2)
                    ->has(Phone::factory()->count(2))
            )
            ->create();

        $response = $this->getJson(route('sellers.index'));

        $response
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => $this->sellerJsonStructure,
                ],
            ]);
    }

    public function test_calling_sellers_should_get_an_error_if_unauthenticated() {
        $response = $this->getJson(route('sellers.index'));

        $response->assertUnauthorized();
    }

    public function test_should_get_a_specific_seller()
    {
        $this->signIn();

        $seller = Seller::factory()
            ->has(
                Client::factory()
                    ->count(2)
                    ->has(Phone::factory()->count(2))
            )
            ->create();

        $response = $this->getJson(route('sellers.show', $seller));

        $response
            ->assertOk()
            ->assertJsonStructure([
                'data' => $this->sellerJsonStructure,
            ]);
    }

    public function test_calling_a_specific_seller_should_get_an_error_if_unauthenticated() {
        $seller = Seller::factory()->create();

        $response = $this->getJson(route('sellers.show', $seller));

        $response->assertUnauthorized();
    }

    public function test_should_create_a_seller_with_valid_fields()
    {
        $this->signIn();

        $data = [
            'name' => $this->faker->name(),
            'email' => $this->faker->email,
            'clients' => [
                ['id' => Client::factory()->create()->id],
                ['id' => Client::factory()->create()->id],
            ]
        ];

        $response = $this->postJson(route('sellers.store'), $data);

        $response
            ->assertValid()
            ->assertCreated()
            ->assertJsonStructure([
                'data' => $this->sellerJsonStructure,
            ]);
    }

    public function test_should_get_an_error_creating_seller_if_fields_are_invalid()
    {
        $this->signIn();

        $data = [
            'name' => $this->faker->name(),
            'email' => $this->faker->email,
            'clients' => [
                ['id' => 0],
            ],
        ];

        $response = $this->postJson(route('sellers.store'), $data);

        $response
            ->assertInvalid(['clients.0.id'])
            ->assertUnprocessable();
    }

    public function test_should_get_an_error_creating_seller_if_unauthenticated()
    {
        $response = $this->postJson(route('sellers.store'), []);

        $response
            ->assertUnauthorized();
    }

    public function test_should_update_a_seller_with_valid_fields()
    {
        $this->signIn();

        $seller = Seller::factory()
            ->has(
                Client::factory()
                    ->has(Phone::factory()->count(2))
            )
            ->create();

        $data = [
            'clients' => [
                ['id' => Client::factory()->create()->id],
                ['id' => Client::factory()->create()->id],
            ]
        ];

        $response = $this->putJson(route('sellers.update', $seller), $data);

        $response
            ->assertValid()
            ->assertOk()
            ->assertJsonStructure([
                'data' => $this->sellerJsonStructure,
            ]);
    }

    public function test_should_get_an_error_updating_seller_if_fields_are_invalid()
    {
        $this->signIn();

        $seller = Seller::factory()->create();

        $data = [
            'email' => 'kevin',
            'clients' => [
                ['id' => 0],
            ]
        ];

        $response = $this->putJson(route('sellers.update', $seller), $data);

        $response
            ->assertInvalid(['email', 'clients.0.id'])
            ->assertUnprocessable();
    }

    public function test_should_get_an_error_updating_seller_if_unauthenticated()
    {
        $seller = Seller::factory()->create();

        $response = $this->putJson(route('sellers.update', $seller), []);

        $response->assertUnauthorized();
    }

    public function test_it_soft_deletes_a_seller()
    {
        $this->signIn();

        $seller = Seller::factory()->create();

        $response = $this->deleteJson(route('sellers.destroy', $seller));

        $response->assertNoContent();

        $this->assertSoftDeleted($seller);
    }

    public function test_calling_seller_gets_an_error_if_deleted()
    {
        $this->signIn();

        $seller = Seller::factory()->create();

        $seller->delete();

        $response = $this->getJson(route('sellers.show', $seller));

        $response->assertNotFound();
    }

    public function test_delete_seller_gets_an_error_if_unauthenticated()
    {
        $seller = Seller::factory()->create();

        $response = $this->deleteJson(route('sellers.destroy', $seller));

        $response->assertUnauthorized();
    }
}
