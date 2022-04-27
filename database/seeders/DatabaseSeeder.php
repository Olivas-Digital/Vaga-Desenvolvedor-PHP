<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\ClientType;
use App\Models\Phone;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'email' => 'kevin@gmail.com'
        ]);

        $sellers = Seller::factory()->count(10)->create();

        $clients = Client::factory()
            ->count(100)
            ->for(ClientType::factory())
            ->has(Phone::factory()->count(2))
            ->create();

        foreach ($sellers as $seller) {
            $seller->clients()->attach($clients->random(10)->modelKeys());
        }
    }
}
