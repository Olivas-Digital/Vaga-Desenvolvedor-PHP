<?php

namespace App\Observers;

use App\Models\Seller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class SellerObserver
{
    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    public $afterCommit = true;

    /**
     * Handle the Seller "created" event.
     *
     * @param Seller $seller
     * @return void
     */
    public function created(Seller $seller)
    {
        Log::info("Seller Creted", [
            'user_id' => auth()->user(),
            'seller_id' => $seller->id,
        ]);

        Cache::forget('sellers');
    }

    /**
     * Handle the Seller "updated" event.
     *
     * @param Seller $seller
     * @return void
     */
    public function updated(Seller $seller)
    {
        Log::info("Seller Updated", [
            'user_id' => auth()->user(),
            'seller_id' => $seller->id,
        ]);

        Cache::forget('sellers');
    }

    /**
     * Handle the Seller "deleted" event.
     *
     * @param Seller $seller
     * @return void
     */
    public function deleted(Seller $seller)
    {
        Log::info("Seller Deleted", [
            'user_id' => auth()->user(),
            'seller_id' => $seller->id,
        ]);

        Cache::forget('sellers');
    }

    /**
     * Handle the Seller "restored" event.
     *
     * @param Seller $seller
     * @return void
     */
    public function restored(Seller $seller)
    {
        //
    }

    /**
     * Handle the Seller "force deleted" event.
     *
     * @param Seller $seller
     * @return void
     */
    public function forceDeleted(Seller $seller)
    {
        //
    }
}
