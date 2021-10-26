<?php

namespace App\Http\Requests\Client;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class ClientSellerSend extends FormRequest
{
    public function rules()
    {
        return [
            'client_id' => 'required',
            'seller_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'client_id.required' => 'Id do cliente é obrigatorio',
            'seller_id.required' => 'Id do vendedor é obrigatório',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Erros de validação',
            'errors'      => $validator->errors(),
        ], Response::HTTP_NOT_ACCEPTABLE));
    }
}
