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

/**
 * @group Sellers
 */
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
     * Index
     *
     * Display a listing of the resource.
     *
     * @apiResourceCollection App\Http\Resources\SellerCollection
     * @apiResourceModel App\Models\Seller with=clients.phones
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
     * Store
     *
     * Store a newly created resource in storage.
     *
     * @apiResource 201 App\Http\Resources\SellerResource
     * @apiResourceModel App\Models\Seller with=clients.phones
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
     * Show
     *
     * Display the specified resource.
     *
     * @apiResource App\Http\Resources\SellerResource
     * @apiResourceModel App\Models\Seller with=clients.phones
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
     * Update
     *
     * Update the specified resource in storage.
     *
     * @apiResource App\Http\Resources\SellerResource
     * @apiResourceModel App\Models\Seller with=clients.phones
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
     * Destroy
     *
     * Remove the specified resource from storage.
     *
     * @response 204 {}
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
