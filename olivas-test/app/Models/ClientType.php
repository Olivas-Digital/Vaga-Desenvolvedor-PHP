<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientType extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'client_type'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    
    public function documentType()
    {
        return $this->hasOne(DocumentType::class);
    }
}
