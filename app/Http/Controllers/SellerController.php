<?php

namespace App\Http\Controllers;

use App\Http\Resources\SellerCollection;
use App\Http\Resources\SellerResource;
use App\Models\Seller;
use App\Http\Requests\StoreSellerRequest;
use App\Http\Requests\UpdateSellerRequest;
use App\Services\SellerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class SellerController extends Controller
{
    /**
     * The game service implementation.
     *
     * @var SellerService
     */
    protected $sellerService;

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct(SellerService $sellerService)
    {
        $this->middleware('auth:api');
        $this->sellerService = $sellerService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return SellerCollection
     */
    public function index(): SellerCollection
    {
        $sellers = Cache::rememberForever('clients', function () {
            return Seller::with(['clients'])->paginate();
        });

        return new SellerCollection($sellers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreSellerRequest $request
     * @return SellerResource
     * @throws Throwable
     */
    public function store(StoreSellerRequest $request): SellerResource
    {
        $seller = $this->sellerService->store($request->validated());

        Cache::forget('sellers');

        return new SellerResource($seller);
    }

    /**
     * Display the specified resource.
     *
     * @param Seller $seller
     * @return SellerResource
     */
    public function show(Seller $seller): SellerResource
    {
        $seller->load('clients');

        return new SellerResource($seller);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateSellerRequest $request
     * @param Seller $seller
     * @return SellerResource
     * @throws Throwable
     */
    public function update(UpdateSellerRequest $request, Seller $seller): SellerResource
    {
        $seller = $this->sellerService->update($seller, $request->validated());

        Cache::forget('sellers');

        return new SellerResource($seller);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Seller $seller
     * @return JsonResponse
     */
    public function destroy(Seller $seller): JsonResponse
    {
        $seller->delete();

        Cache::forget('sellers');

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
