<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendedor extends Model
{

    // minha tabela tem outro nome
    protected $table = 'vendedor';

    // tirar a opção de created_at updated_at das tabelas
    public $timestamps = false;

    protected $fillable = ['nome', 'email']; 
}

    //AQUI VAI OS RELACIONAMENTOS COM O ELOQUENT
