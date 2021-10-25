<?php

namespace Database\Seeders;

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
        // \App\Models\User::factory(10)->create();
        // \App\Models\Seller::factory(15)->create();
        // \App\Models\Client::factory(15)->create();
        // \App\Models\ClientPhone::factory(15)->create();
        // \Database\Factories\DocumentTypeFactory::generate();
        \App\Models\ClientType::factory()->generate(15);
    }
}
