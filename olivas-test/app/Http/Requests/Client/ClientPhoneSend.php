<?php

namespace App\Http\Requests\Client;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class ClientPhoneSend extends FormRequest
{
    public function rules()
    {
        return [
            'client_id' => 'required',
            'phone_number' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'client_id.required' => 'Id do cliente é obrigatorio',
            'phone_number.required' => 'Número de telefone é obrigatório',
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
