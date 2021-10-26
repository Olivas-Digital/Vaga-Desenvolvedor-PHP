<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentType extends Model
{
    use HasFactory;

    protected $fillable = ['initials', 'description'];

    public function document()
    {
        return $this->belongsTo(ClientType::class);
    }
}
