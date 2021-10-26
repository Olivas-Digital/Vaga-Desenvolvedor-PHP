<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable  = ['name', 'email', 'image_path'];

    public function phones()
    {
        return $this->hasMany(ClientPhone::class);
    }

    public function sellers()
    {
        return $this->hasMany(ClientSeller::class);
    }
    
    public function types()
    {
        return $this->hasMany(ClientType::class);
    }
}
