<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CustomerType;
use App\Models\CustomerPhone;
use App\Models\Seller;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'image', 'email', 'customer_type_id'];

    /**
     * Get the customer type that owns the customer.
     */
    public function customerType()
    {
        return $this->belongsTo(CustomerType::class);
    }

    /**
     * Get the phones for the customer.
     */
    public function phones()
    {
        return $this->hasMany(CustomerPhone::class);
    }

    /**
     * The sellers that belong to the customer.
     */
    public function sellers()
    {
        return $this->belongsToMany(Seller::class);
    }

    /**
     * Get the validation rules.
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'image' => 'bail|file|mimes:png,jpg,jpeg',
            'email' => 'bail|required|email|unique:customers,email,'.$this->id,
            'phones' => 'required',
            'sellers' => 'required',
            'customer_type_id' => 'bail|required|exists:customer_types,id'
        ];
    }

    /**
     * Get the messages of validation rules.
     */
    public function validationMessages()
    {
        return [
            'name.required' => 'O campo nome precisa ser preenchido!',
            'image.file' => 'No campo imagem deve ser passado um arquivo de imagem',
            'image.mimes' => 'A imagem precisa estar no formato: png, jpg ou jpeg',
            'email.required' => 'O campo email precisa ser preenchido!',
            'email.email' => 'Insira um email válido!',
            'email.unique' => 'Este email ja está em uso por outro cliente!!',
            'customer_type_id.required' => 'Informe o tipo de cliente!',
            'customer_type_id.exists' => 'O tipo de cliente informado é inválido!',
            'phones.required' => 'Informe ao menos um numero de telefone',
            'sellers.required' => 'Informe ao menos um vendedor',
        ];
    }
}
