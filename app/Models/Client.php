<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\Client
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property int $client_type_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read ClientType $clientType
 * @property-read Collection|Phone[] $phones
 * @property-read int|null $phones_count
 * @property-read Collection|Seller[] $sellers
 * @property-read int|null $sellers_count
 * @mixin Eloquent
 */
class Client extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'client_type_id',
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = [
        'phones',
        'clientType',
    ];

    /**
     * Get the type that owns the client.
     */
    public function clientType(): BelongsTo
    {
        return $this->belongsTo(ClientType::class);
    }

    /**
     * Get the phones for the client.
     */
    public function phones(): HasMany
    {
        return $this->hasMany(Phone::class);
    }

    /**
     * The sellers that belong to the client.
     */
    public function sellers(): BelongsToMany
    {
        return $this->belongsToMany(Seller::class);
    }
}
