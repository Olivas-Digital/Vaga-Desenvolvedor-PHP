<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Customer;
use App\Models\CustomerPhone;
use App\Models\CustomerType;

class CustomerController extends Controller
{
    private $customer;

    public function __construct(Customer $customer)
    {
        return $this->customer = $customer;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function page()
    {
        $customerTypes = CustomerType::all();
        return view('app.customers', ['customerTypes' => $customerTypes]);
    }

    /**
     * Return a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('filters')) {
            $filters = explode(';', $request->filters);
            foreach ($filters as $filter) {
                if ($filter == null) {
                    break;
                }
                $where = explode(',', $filter);
                $this->customer = $this->customer->where($where[0], $where[1], $where[2]);
            }
        } 
        
        if ($request->has('page')) {
            $customer = $this->customer->with(['sellers', 'phones', 'customerType'])->paginate(10);
        } else {
            $customer = $this->customer->with(['sellers', 'phones', 'customerType'])->get();
        }

        return response()->json($customer, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->customer->rules(), $this->customer->validationMessages());

        $image = $request->file('image');
        $nameImage = $image->store('images/customers' ,'public');

        $data = $request->all();
        $data['image'] = $nameImage;
        $customer = $this->customer->create($data);

        foreach ($request->phones as $phone) {
            CustomerPhone::create(['customer_id' => $customer->id, 'phone' => $phone]);
        }

        $customer->sellers()->attach($request->sellers);

        return response()->json(['message' => "ID do cliente: $customer->id"], 201);
    }

    /**
     * Return the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = $this->customer->find($id);

        if ($customer === null) {
            return  response()->json(['error' => 'Este cliente não está cadastrado!'], 404);
        }

        return response()->json($customer, 200);
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
        $customer = $this->customer->find($id);

        if ($customer == null){
            return  response()->json(['error' => 'Este vendedor não está cadastrado!'], 404);
        }
        
        $data = $request->all();
        
        if ($request->has('image')) {
            $request->validate($customer->rules(), $customer->validationMessages());

            Storage::disk('public')->delete($customer->image);
            $image = $request->file('image');
            $data['image'] = $image->store('images/customers', 'public');
        } else {
            $rules = $customer->rules();
            unset($rules['image']);

            $request->validate($rules, $customer->validationMessages());
        }

        $customer->update($data);
        
        foreach ($customer->phones as $phone) {
            if (! in_array($phone->phone, $request->phones)) {
                $phone->delete();
            }
        }

        $customerPhones = [];
        foreach ($customer->phones as $phone) {
            $customerPhones[] = $phone->phone;
        }

        foreach ($request->phones as $phone) {
            if (! in_array($phone, $customerPhones)) {
                CustomerPhone::create(['customer_id' => $customer->id, 'phone' => $phone]);
            }
        }

        $customer->sellers()->sync($request->sellers);

        return response()->json(['message' => 'Os dados do cliente foram atualizadas com sucesso!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = $this->customer->find($id);

        if ($customer == null){
            return  response()->json(['error' => 'Este cliente não está cadastrado!'], 404);
        }

        Storage::disk('public')->delete($customer->image);
        $customer->phones()->delete();
        $customer->sellers()->detach();
        $customer->delete();

        return response()->json(['message' => 'Cliente removido com sucesso!'], 200);
    }
}
