<?php

namespace App\Services;

use App\Models\Seller;
use Illuminate\Support\Facades\DB;
use Throwable;

class SellerService
{
    /**
     * Store a newly created resource in storage.
     *
     * @throws Throwable
     */
    public function store(array $validated)
    {
        $seller = DB::transaction(function () use ($validated) {
            $seller = Seller::create($validated);

            if (array_key_exists('clients', $validated)) {
                $clients = collect($validated['clients'])->map(function ($item) {
                    return $item['id'];
                })->toArray();

                $seller->clients()->attach($clients);
            }

            return $seller;
        });

        $seller->load(['clients']);

        return $seller;
    }

    /**
     * Update the specified resource in storage.
     *
     * @throws Throwable
     */
    public function update(Seller $seller, array $validated): Seller
    {
        DB::transaction(function () use ($seller, $validated) {
            $seller->update($validated);

            if (array_key_exists('clients', $validated)) {
                $clients = collect($validated['clients'])->map(function ($item) {
                    return $item['id'];
                })->toArray();

                $seller->clients()->sync($clients);
            }

            return $seller;
        });

        $seller->load(['clients']);

        return $seller;
    }
}
