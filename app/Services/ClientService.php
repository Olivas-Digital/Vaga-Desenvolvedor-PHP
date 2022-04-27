<?php

namespace App\Services;

use App\Models\Client;
use Illuminate\Support\Facades\DB;
use Throwable;

class ClientService
{
    /**
     * Store a newly created resource in storage.
     *
     * @throws Throwable
     */
    public function store(array $validated)
    {
        $client = DB::transaction(function () use ($validated) {
            $client = Client::create($validated);

            if (array_key_exists('phones', $validated)) {
                $client->phones()->createMany($validated['phones']);
            }

            if (array_key_exists('sellers', $validated)) {
                $sellers = collect($validated['sellers'])->map(function ($item) {
                    return $item['id'];
                })->toArray();

                $client->sellers()->attach($sellers);
            }

            return $client;
        });

        $client->load(['clientType', 'phones', 'sellers']);

        // TODO: dispatch welcome email

        return $client;
    }

    /**
     * Update the specified resource in storage.
     *
     * @throws Throwable
     */
    public function update(Client $client, array $validated): Client
    {
        DB::transaction(function () use ($client, $validated) {
            $client->update($validated);

            if (array_key_exists('phones', $validated)) {
                $client->phones()->forceDelete();
                $client->phones()->createMany($validated['phones']);
            }

            if (array_key_exists('sellers', $validated)) {
                $sellers = collect($validated['sellers'])->map(function ($item, $key) {
                    return $item['id'];
                })->toArray();

                $client->sellers()->sync($sellers);
            }

            return $client;
        });

        $client->load(['clientType', 'phones', 'sellers']);

        return $client;
    }
}
