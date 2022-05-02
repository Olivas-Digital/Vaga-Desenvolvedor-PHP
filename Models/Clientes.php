<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    // minha tabela tem outro nome
    protected $table = 'clientes';

    // tirar a opção de created_at updated_at das tabelas
    public $timestamps = false;

    // campos preenchidos pelo Request::all()
    protected $fillable = ['nome', 'email','imagem', 'telefone', 'tipocliente','vendedor']; 

    
}


    //AQUI VAI OS RELACIONAMENTOS COM O ELOQUENT