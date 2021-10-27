<?php

namespace App\Http\Controllers;

use App\Http\Requests\Seller\SellerSend;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SellerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $inputSearch = $request->get('search');

        $data = $inputSearch ? Seller::where('name', 'like',  '%' . $inputSearch . '%')->paginate(8) : Seller::orderBy('id', 'DESC')->paginate(8);

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
    public function store(SellerSend $request)
    {
        // $request->all();
        $validated = $request->validated();
        extract($validated);

        $tradeNameExists = Seller::where('trade_name', '=', $trade_name)->exists();

        if ($tradeNameExists) {
            return response()->json([
                'message' => 'Nome fantasia: "' . $trade_name . '" já existe',
            ], Response::HTTP_FORBIDDEN);
        }

        Seller::create($validated);

        return response()->json([
            'message' => 'Vendedor cadastrado!',
            'data' => $validated
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(SellerSend $request, $id)
    {
        // $request->all();
        $validated = $request->validated();
        extract($validated);

        $tradeNameExists = Seller::where('trade_name', '=', $trade_name)
            ->where('id', '!=', $id)
            ->exists();

        if ($tradeNameExists) {
            return response()->json([
                'message' => 'Nome fantasia: "' . $trade_name . '" já existe',
            ], Response::HTTP_FORBIDDEN);
        }

        Seller::where('id', '=', $id)
            ->update($validated);

        return response()->json([
            'message' => 'Vendedor atualizado!',
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

        $sellerExists =  Seller::where('id', '=', $id)->exists();
        if (!$sellerExists) {
            return response()->json([
                'message' => 'Vendedor não existe!',
                'data' => $id,
            ], Response::HTTP_NOT_FOUND);
        }

        Seller::where('id', '=', $id)
            ->delete();

        return response()->json([
            'message' => 'Vendedor deletado!',
            'data' => $id,
        ], Response::HTTP_OK);
    }
}