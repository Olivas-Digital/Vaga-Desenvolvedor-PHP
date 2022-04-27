<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\ClientType
 *
 * @property int $id
 * @property string $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Client[] $clients
 * @property-read int|null $clients_count
 * @mixin Eloquent
 */
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
