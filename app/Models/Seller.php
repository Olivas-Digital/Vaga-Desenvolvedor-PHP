<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;

class Seller extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * The customers that belong to the seller.
     */
    public function customers()
    {
        return $this->belongsToMany(Customer::class);
    }
}
