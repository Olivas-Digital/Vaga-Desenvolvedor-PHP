<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerType extends Model
{
    use HasFactory;

    // Disable timestamps columns
    public $timestamps = false;

    /**
     * Get the customers for the customer type.
     */
    public function customers()
    {
        return $this->hasMany(Customer::class);
    }
}
