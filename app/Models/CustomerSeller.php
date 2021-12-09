<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CustomerSeller extends Pivot
{
    // Disable timestamps columns
    public $timestamps = false;
}
