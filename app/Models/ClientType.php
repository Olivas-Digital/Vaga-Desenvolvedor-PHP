<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ClientType extends Model
{
    use HasFactory;

    const PF = 1;
    const PJ = 2;

    /**
     * The clients that belong to the type.
     */
    public function clients(): BelongsToMany
    {
        return $this->belongsToMany(Client::class);
    }
}
