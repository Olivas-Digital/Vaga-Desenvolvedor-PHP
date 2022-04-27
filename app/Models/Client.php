<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

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
