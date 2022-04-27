<?php

namespace App\Observers;

use App\Models\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ClientObserver
{
    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    public $afterCommit = true;

    /**
     * Handle the Client "created" event.
     *
     * @param Client $client
     * @return void
     */
    public function created(Client $client)
    {
        Log::info("Client Created", [
            'user_id' => auth()->user(),
            'client_id' => $client->id,
        ]);

        Cache::forget('clients');
    }

    /**
     * Handle the Client "updated" event.
     *
     * @param Client $client
     * @return void
     */
    public function updated(Client $client)
    {
        Log::info("Client Updated", [
            'user_id' => auth()->user(),
            'client_id' => $client->id,
        ]);

        Cache::forget('clients');
    }

    /**
     * Handle the Client "deleted" event.
     *
     * @param Client $client
     * @return void
     */
    public function deleted(Client $client)
    {
        Log::info("Client Deleted", [
            'user_id' => auth()->user(),
            'client_id' => $client->id,
        ]);

        Cache::forget('clients');
    }

    /**
     * Handle the Client "restored" event.
     *
     * @param Client $client
     * @return void
     */
    public function restored(Client $client)
    {
        //
    }

    /**
     * Handle the Client "force deleted" event.
     *
     * @param Client $client
     * @return void
     */
    public function forceDeleted(Client $client)
    {
        //
    }
}
