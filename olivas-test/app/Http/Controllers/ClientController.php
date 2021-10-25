<?php

namespace App\Http\Controllers;

use App\Http\Requests\Client\ClientSend;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $inputSearch = $request->get('search');

        $data = $inputSearch ? Client::where('name', 'like',  '%' . $inputSearch . '%')->paginate(5) : Client::orderBy('id', 'DESC')->paginate(5);

        return response()->json([
            'data' => $data,
            'response_text' => 'Success : ' . Response::HTTP_OK
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientSend $request)
    {
        // $request->all();
        $validated = $request->validated();
        $validated['image_path'] = '';
        extract($validated);

        $clientExists = Client::where('email', '=', $email)->exists();

        if ($clientExists) {
            return response()->json([
                'message' => 'Cliente com email: "' . $email . '" já existe',
            ], Response::HTTP_FORBIDDEN);
        }

        Client::create($validated);

        return response()->json([
            'message' => 'Cliente cadastrado!',
            'data' => $validated
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(ClientSend $request, $id)
    {
        // $request->all();
        $validated = $request->validated();
        $validated['image_path'] = '';
        extract($validated);

        $clientExists = Client::where('email', '=', $email)
            ->where('id', '!=', $id)
            ->exists();

        if ($clientExists) {
            return response()->json([
                'message' => 'Cliente com email: "' . $email . '" já existe',
            ], Response::HTTP_FORBIDDEN);
        }

        Client::where('id', '=', $id)
            ->update($validated);

        return response()->json([
            'message' => 'Cliente atualizado!',
            'data' => $validated
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $sellerExists =  Client::where('id', '=', $id)->exists();
        if (!$sellerExists) {
            return response()->json([
                'message' => 'Cliente não existe!',
                'data' => $id,
            ], Response::HTTP_NOT_FOUND);
        }

        Client::where('id', '=', $id)
            ->delete();

        return response()->json([
            'message' => 'Cliente deletado!',
            'data' => $id,
        ], Response::HTTP_OK);
    }
}
