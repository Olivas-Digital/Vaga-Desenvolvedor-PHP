<?php

namespace App\Http\Controllers;

use App\Http\Requests\Client\ClientSellerSend;
use App\Models\Client;
use App\Models\ClientSeller;
use App\Models\Seller;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ClientSellerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = ClientSeller::orderBy('client_id')->get();

        return response()->json([
            'data' => $data,
            'response_text' => 'Success : ' . Response::HTTP_OK,
        ], Response::HTTP_OK);
    }

    public function show(Request $request, $clientId)
    {
        $data = ClientSeller::where('client_id', $clientId)->get();

        return response()->json([
            'data' => $data,
            'response_text' => 'Success : ' . Response::HTTP_OK,
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientSellerSend $request)
    {
        $validated = $request->validated();
        extract($validated);

        $this->verifyClientSellerIdExists($client_id, $seller_id);
        $this->verifyIfClientAlreadyHaveSeller($client_id, $seller_id);

        ClientSeller::create($validated);

        return response()->json([
            'message' => "Vendedor de id: $seller_id foi cadastrado para o cliente de id: $client_id",
            'data' => $validated
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(ClientSellerSend $request, $clientSellerId)
    {
        $validated = $request->validated();
        extract($validated);

        $this->verifyClientSellerIdExists($client_id, $seller_id);
        $this->verifyIdInClientSellerTable($clientSellerId);

        ClientSeller::where('id', '=', $clientSellerId)
            ->update($validated);

        return response()->json([
            'message' => "Registro de clientes e vendedores com id: $clientSellerId, atualizado!",
            'data' => $validated,
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $clientSellerId)
    {
        $this->verifyIdInClientSellerTable($clientSellerId);

        $clientPhone = ClientSeller::where('id', '=', $clientSellerId);
        $clientPhone->delete();

        return response()->json([
            'message' => "Registro de cliente vendedor com id: $clientSellerId foi deletado!",
        ], Response::HTTP_OK);
    }

    public function verifyClientSellerIdExists($client_id, $seller_id)
    {
        $clientExists = Client::where('id', '=', $client_id)->exists();

        if (!$clientExists) {
            throw new HttpResponseException(response()->json([
                'success'   => false,
                'message' => "Cliente com id: $client_id não existe!",
            ], Response::HTTP_NOT_ACCEPTABLE));
        }

        $sellerExists = Seller::where('id', '=', $seller_id)->exists();
        if (!$sellerExists) {
            throw new HttpResponseException(response()->json([
                'success'   => false,
                'message' => "Vendedor com id: $seller_id não existe!",
            ], Response::HTTP_NOT_ACCEPTABLE));
        }
    }

    public function verifyIdInClientSellerTable($clientSellerId)
    {
        $clientSellerExists = ClientSeller::where('id', '=', $clientSellerId)->exists();

        if (!$clientSellerExists) {
            throw new HttpResponseException(response()->json([
                'message' => "Não existe um registro de clientes e vendedores com id: $clientSellerId",
            ], Response::HTTP_NOT_ACCEPTABLE));
        }
    }

    public function verifyIfClientAlreadyHaveSeller($client_id, $seller_id)
    {
        $clientSameSeller = ClientSeller::where('client_id', '=', $client_id)->where('seller_id', '=', $seller_id);

        $clientSameSellerExist = $clientSameSeller->exists();

        if ($clientSameSellerExist) {
            throw new HttpResponseException(response()->json([
                'message' => "Cliente já possui o vendedor de id: $seller_id",
            ], Response::HTTP_NOT_ACCEPTABLE));
        }
    }
}
