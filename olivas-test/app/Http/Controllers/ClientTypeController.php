<?php

namespace App\Http\Controllers;

use App\Http\Requests\Client\ClientTypeSend;
use App\Models\Client;
use App\Models\ClientType;
use App\Models\DocumentType;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ClientTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = ClientType::get();

        return response()->json([
            'data' => $data,
            'response_text' => 'Success : ' . Response::HTTP_OK,
        ], Response::HTTP_OK);
    }

    public function show(Request $request, $clientId)
    {
        $data = ClientType::where('client_id', $clientId)->get();

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
    public function store(ClientTypeSend $request)
    {
        $validated = $request->validated();
        extract($validated);

        $clientExists = Client::where('id', '=', $client_id)->exists();
        
        if (!$clientExists) {
            return response()->json([
                'message' => "Cliente con id: $client_id não existe!",
            ], Response::HTTP_FORBIDDEN);
        }
        
        $typeExist = DocumentType::where('id', '=', $client_type)->exists();
        
        if (!$typeExist) {
            return response()->json([
                'message' => "O tipo de documento para clientes com id: $client_type, não existe!",
            ], Response::HTTP_FORBIDDEN);
        }
        
        $clientAlreadyHaveType = ClientType::where('client_id', '=', $client_id)
            ->where('client_type', '=', $client_type)
            ->exists();

        if ($clientAlreadyHaveType) {
            return response()->json([
                'message' => "Cliente: $client_id já tem documento com tipo: $client_type",
            ], Response::HTTP_FORBIDDEN);
        }

        ClientType::create($validated);

        return response()->json([
            'message' => 'Tipo de documento: ' . $client_type . ' foi cadastrado para o cliente: ' . $client_id,
            'data' => $validated
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $clientId)
    {
        $clientType = $request->client_type;
        if (!$clientType) {
            return response()->json([
                'message' => "Envie o id para tipo de cliente",
            ], Response::HTTP_FORBIDDEN);
        }

        $clientExists = clientType::where('client_id', '=', $clientId)->exists();

        if (!$clientExists) {
            return response()->json([
                'message' => "Cliente com id: $clientId não possui documentos cadastrados.",
            ], Response::HTTP_FORBIDDEN);
        }

        $clientWithType = ClientType::where('client_id', '=', $clientId)->where('client_type', '=', $clientType);
        $clientWithTypeExists = $clientWithType->exists();

        if (!$clientWithTypeExists) {
            return response()->json([
                'message' => "Cliente com id: $clientId não possui o tipo de documento com id: $clientType",
            ], Response::HTTP_FORBIDDEN);
        }

        $clientWithType->delete();

        return response()->json([
            'message' => "Tipo de documento: $clientType do cliente: $clientId foi deletado!",
        ], Response::HTTP_OK);
    }
}
