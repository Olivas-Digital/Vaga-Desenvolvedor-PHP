<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerPhone extends Model
{
    use HasFactory;

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
