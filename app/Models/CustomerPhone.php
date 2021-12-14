<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;

class CustomerPhone extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'phone'];

    // Disable timestamps columns
    public $timestamps = false;

    /**
     * Get the customer that owns the phone.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
