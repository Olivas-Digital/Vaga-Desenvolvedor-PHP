<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CustomerType;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        CustomerType::factory()->cnpj()->create();
        CustomerType::factory()->cpf()->create();
        // \App\Models\User::factory(10)->create();
    }
}
