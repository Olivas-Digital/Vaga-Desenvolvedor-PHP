<?php

namespace App\Http\Controllers;

use App\Http\Requests\Client\ClientSend;
use App\Models\Client;
use App\Models\DocumentType;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

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

        $data = $inputSearch ? Client::where('name', 'like',  '%' . $inputSearch . '%')->paginate(8) : Client::orderBy('id', 'DESC')->paginate(8);

        return response()->json([
            'data' => $data,
            'response_text' => 'Success : ' . Response::HTTP_OK,
        ], Response::HTTP_OK);
    }

    public function show(Request $request, $id)
    {
        $client = Client::find($id);
        $phones = $client->phones()->get();
        $sellers = $client->sellers()->get();
        $types = $client->types()->get();
        $documentTypes = [];
        foreach ($types as $type) {
            $documentTypes[] = DocumentType::find($type->client_type);
        }

        $dataInfo = [
            'client' => [
                'info' => $client,
                'types' => $documentTypes,
                'phones' => $phones,
                'sellers' => $sellers,
            ]
        ];

        return response()->json([
            'data' => $dataInfo,
            'response_text' => 'Success : ' . Response::HTTP_OK,
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
        extract($validated);

        $clientExists = Client::where('email', '=', $email)->exists();

        if ($clientExists) {
            return response()->json([
                'message' => 'Cliente com email: "' . $email . '" já existe',
            ], Response::HTTP_FORBIDDEN);
        }

        $queryId = DB::table('clients')->latest('id')->first();
        $nextId = $queryId->id + 1;

        $validated['image_path'] = $this->imgClientHandle($request, $nextId);
        unset($validated['image']);

        Client::create($validated);

        $this->sendEmailToClient($name);

        return response()->json([
            'message' => 'Cliente cadastrado!',
            'data' => $validated
        ], Response::HTTP_OK);
    }

    public function sendEmailToClient($name)
    {
        // .env variable to simulate client email
        $clientMail = $_ENV['CLIENT_EMAIL'];
        $details = [
            'title' => "$name seja bem vindo! ",
            'body' => "Seus dados foram cadastrados com sucesso!"
        ];
        $mailInstace = new \App\Mail\ClientMail($details);
        \Mail::to($clientMail)->send($mailInstace);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(ClientSend $request, $id)
    {
        $request->all();
        $validated = $request->validated();
        extract($validated);

        $clientExists = Client::where('email', '=', $email)
            ->where('id', '!=', $id)
            ->exists();

        if ($clientExists) {
            return response()->json([
                'message' => 'Cliente com email: "' . $email . '" já existe',
            ], Response::HTTP_FORBIDDEN);
        }

        $validated['image_path'] = $this->imgClientHandle($request, $id);
        unset($validated['image']);

        Client::where('id', '=', $id)
            ->update($validated);

        return response()->json([
            'message' => 'Cliente atualizado!',
            'data' => $validated,
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

        $imgToDelete = Client::where('id', '=', $id)->first(['image_path'])->image_path;
        File::delete($imgToDelete);

        Client::where('id', '=', $id)
            ->delete();

        return response()->json([
            'message' => 'Cliente deletado!',
            'data' => $id,
        ], Response::HTTP_OK);
    }

    public function imgClientHandle($request, $id)
    {
        $isImgRequestAString = is_string($request->image);
        if ($isImgRequestAString) return $request->image;

        $imageName = 'client_' . $id . '_' . $request->image->getClientOriginalName();

        $clientsImgPath = 'images/api/clients/';
        $currentImgPath = $clientsImgPath . $imageName;
        $queryPath = Client::where('id', '=', $id)->first(['image_path']);

        if (!$queryPath) {
            $request->image->move($clientsImgPath, $imageName);
            return $currentImgPath;
        }

        $clientStoredImgPath = $queryPath->image_path;

        $equalImgs = $clientStoredImgPath == $currentImgPath;

        if (!$equalImgs) {
            $fileExists = File::exists($clientStoredImgPath);
            $fileExists ? File::delete($clientStoredImgPath) : false;
        }

        if (!File::exists($currentImgPath)) {
            $request->image->move($clientsImgPath, $imageName);
        }

        return $currentImgPath;
    }
}
