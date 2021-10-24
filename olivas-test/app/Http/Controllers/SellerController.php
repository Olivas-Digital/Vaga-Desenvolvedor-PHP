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
        $inputSearch = $request->input('search');

        $data = $inputSearch ? Seller::where('name', 'like',  '%' . $inputSearch . '%')->paginate(5) : Seller::orderBy('id', 'DESC')->paginate(5);

        return response()->json([
            'data' => $data,
            'response_text' => 'Success : ' . Response::HTTP_OK
        ]);
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
     * @param  \App\Models\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function update(SellerSend $request, Seller $seller)
    {
        // $request->all();
        $validated = $request->validated();
        extract($validated);

        $tradeNameExists = Seller::where('id', '!=', $seller, 'trade_name', '=', $trade_name)->exists();

        if ($tradeNameExists) {
            return response()->json([
                'message' => 'Nome fantasia: "' . $trade_name . '" já existe',
            ], Response::HTTP_FORBIDDEN);
        }

        Seller::create($validated);

        return response()->json([
            'message' => 'Vendedor atualizado!',
            'data' => $validated
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function destroy(Seller $seller)
    {
        //
    }
}
