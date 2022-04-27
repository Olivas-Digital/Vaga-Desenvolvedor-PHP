<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClientCollection;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Services\ClientService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class ClientController extends Controller
{
    /**
     * The game service implementation.
     *
     * @var ClientService
     */
    protected $clientService;

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct(ClientService $clientService)
    {
        $this->middleware('auth:api');
        $this->clientService = $clientService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return ClientCollection
     */
    public function index(): ClientCollection
    {
        $clients = Cache::rememberForever('clients', function () {
            return Client::with(['sellers'])->paginate();
        });

        return new ClientCollection($clients);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreClientRequest $request
     * @return ClientResource
     * @throws Throwable
     */
    public function store(StoreClientRequest $request): ClientResource
    {
        $client = $this->clientService->store($request->validated());

        Cache::forget('clients');

        return new ClientResource($client);
    }

    /**
     * Display the specified resource.
     *
     * @param Client $client
     * @return ClientResource
     */
    public function show(Client $client): ClientResource
    {
        $client->load('sellers');

        return new ClientResource($client);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateClientRequest $request
     * @param Client $client
     * @return ClientResource
     * @throws Throwable
     */
    public function update(UpdateClientRequest $request, Client $client): ClientResource
    {
        $client = $this->clientService->update($client, $request->validated());

        Cache::forget('clients');

        return new ClientResource($client);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Client $client
     * @return JsonResponse
     */
    public function destroy(Client $client): JsonResponse
    {
        $client->delete();

        Cache::forget('clients');

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
