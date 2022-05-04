<?php

namespace App\Http\Requests\Seller;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class SellerSend extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'trade_name' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nome do vendedor é obrigatório',
            'trade_name.required' => 'Nome fantasia é obrigatório'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Erros de validação',
            'errors'      => $validator->errors()
        ], Response::HTTP_NOT_ACCEPTABLE));
    }
}
