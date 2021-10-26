<?php

namespace App\Http\Controllers;

use App\Http\Requests\Client\ClientPhoneSend;
use App\Models\Client;
use App\Models\ClientPhone;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ClientPhoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = ClientPhone::get();

        return response()->json([
            'data' => $data,
            'response_text' => 'Success : ' . Response::HTTP_OK,
        ], Response::HTTP_OK);
    }

    public function show(Request $request, $clientId)
    {
        $data = ClientPhone::where('client_id', $clientId)->get();

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
    public function store(ClientPhoneSend $request)
    {
        $validated = $request->validated();
        extract($validated);

        $clientExists = Client::where('id', '=', $client_id)->exists();

        if (!$clientExists) {
            return response()->json([
                'message' => "Cliente con id: $client_id não existe!",
            ], Response::HTTP_FORBIDDEN);
        }

        $clientSamePhoneNumber = ClientPhone::find($client_id)
            ->where('phone_number', '=', $phone_number)
            ->exists();

        if ($clientSamePhoneNumber) {
            return response()->json([
                'message' => "Cliente já possui um telefone com id: $clientSamePhoneNumber",
            ], Response::HTTP_FORBIDDEN);
        }

        ClientPhone::create($validated);

        return response()->json([
            'message' => "Telefone: $phone_number foi cadastrado para o cliente de id: $client_id",
            'data' => $validated
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(ClientPhoneSend $request, $clientPhoneId)
    {
        $validated = $request->validated();
        extract($validated);

        $clientExists = Client::where('id', '=', $client_id)->exists();

        if (!$clientExists) {
            return response()->json([
                'message' => "Cliente com id: $client_id não existe.",
            ], Response::HTTP_FORBIDDEN);
        }

        $clientPhoneExists = ClientPhone::where('id', '=', $clientPhoneId)->exists();

        if (!$clientPhoneExists) {
            return response()->json([
                'message' => "Não existe um registro de telefone com id: $clientPhoneId",
            ], Response::HTTP_FORBIDDEN);
        }

        ClientPhone::where('id', '=', $clientPhoneId)
            ->update($validated);

        return response()->json([
            'message' => "Registro de telefone com id: $clientPhoneId do cliente com id: $client_id atualizado!",
            'data' => $validated,
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $clientPhoneId)
    {
        $clientPhone = ClientPhone::where('id', '=', $clientPhoneId);
        $clientPhoneExists = $clientPhone->exists();

        if (!$clientPhoneExists) {
            return response()->json([
                'message' => "Não existe um registro de telefone com id: $clientPhoneId",
            ], Response::HTTP_FORBIDDEN);
        }

        $clientPhone->delete();

        return response()->json([
            'message' => "Registro de telefone com id: $clientPhoneId foi deletado!",
        ], Response::HTTP_OK);
    }
}
