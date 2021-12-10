<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
