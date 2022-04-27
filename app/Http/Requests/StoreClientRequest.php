<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:clients,email',
            'client_type_id' => 'required|integer|exists:client_types,id',
            'phones' => 'required|array|min:1',
            'phones.*.number' => 'required|string|unique:phones,number',
            'sellers' => 'sometimes|required|array',
            'sellers.*.id' => 'required|integer|exists:sellers,id',
        ];
    }
}
