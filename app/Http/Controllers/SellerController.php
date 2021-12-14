<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seller;

class SellerController extends Controller
{
    private $seller;

    public function __construct(Seller $seller)
    {
        $this->seller = $seller;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function page()
    {
        return view('app.sellers');
    }

    /**
     * Return a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request  $request)
    {
        if ($request->has('filters')) {
            $filters = explode(';', $request->filters);
            foreach ($filters as $filter) {
                if ($filter == null) {
                    break;
                }
                $where = explode(',', $filter);
                $this->seller = $this->seller->where($where[0], $where[1], $where[2]);
            }
        } 
        
        if ($request->has('page')) {
            $sellers = $this->seller->with('customers')->paginate(10);
        } else {
            $sellers = $this->seller->with('customers')->get();
        }

        return response()->json($sellers, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ], [
            'name.required' => 'O campo nome precisa ser informado!'
        ]);
        $seller = $this->seller->create($request->all());
        return response()->json(['message' => "ID do vendedor: $seller->id"], 201);
    }

    /**
     * Return the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $seller = $this->seller->find($id);

        if ($seller === null) {
            return  response()->json(['error' => 'Este vendedor não está cadastrado!'], 404);
        }

        return response()->json($seller, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $seller = $this->seller->find($id);

        if ($seller == null){
            return  response()->json(['error' => 'Este vendedor não esta cadastrado!'], 404);
        }

        $request->validate([
            'name' => 'required',
        ], [
            'name.required' => 'O campo nome não pode estar vazio!'
        ]);

        $seller->update($request->all());
        return response()->json(['message' => 'Os dados do vendedor foram atualizadas com sucesso!'], 200);
    }

    /**
     * Remove or disable the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $seller = $this->seller->find($id);

        if ($seller == null){
            return  response()->json(['error' => 'Este vendedor não está cadastrado!'], 404);
        }

        $seller->delete();
        return response()->json(['message' => 'Vendedor removido com sucesso!'], 200);
    }
}