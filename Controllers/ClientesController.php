<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Clientes;

class ClientesController extends Controller
{
    //

    public function create(){

        return view('clientes.create');

    }

    public function store(Request $request){

        $nome = $request -> nome;
        $email = $request -> email;
        $imagem = $request -> imagem;
        $telefone = $request -> telefone;
        $tipocliente = $request -> tipocliente;
        $idvendedor = $request -> idvendedor;

        //FAZER VERIFICACOES ADICIONAIS , SE EMAIL É VALIDO ETC..
        if(strlen($nome)<4 && strlen($email)<4){

            return "Erro, seu nome e seu email sao invalidos";
        }
        if($tipocliente=="Pessoa Física" || $tipocliente=="Pessoa Jurídica"){}else{
            return "Tipo de pessoa deve ser 'Pessoa Fisica' ou 'Pessoa Juridica'".$tipocliente;
        }

        //dd($request->all());  //imprimirá na tela todas as informações que estão chegando

        //Chama a classe Vendedor que esta dentro da models/vendedor.php
        Clientes::create([
            'nome' => $nome,
            'email' => $email,
            'imagem' => $imagem,
            'telefone' => $telefone,
            'tipocliente' => $tipocliente,
            'vendedor' => $idvendedor
        ]);

        return "Cliente cadastrado com sucesso";
    }



    //READ (SELECT) 
    public function show($id){

        $clientes = Clientes::findOrFail($id);
        //var_dump($vendedor);
        return view('clientes.show', ['clientes' => $clientes]);

    }



    //UPDATE (UPDATE) 
    public function editar($id){

        $clientes = Clientes::findOrFail($id);
        //var_dump($vendedor);
        return view('clientes.editar', ['clientes' => $clientes]);

    }

    public function update(Request $request, $id){

        $clientes = Clientes::findOrFail($id);

        $clientes ->update([
            'nome' => $request->nome,
            'email' => $request->email,
            'imagem' => $request->imagem,
            'telefone' => $request->telefone,
            'tipocliente' => $request->tipocliente,
            'vendedor' => $request->vendedor
        ]);

        return "Dados atualizados do cliente com sucesso";

    }




    //DELETE 
    public function delete($id){

        $clientes = Clientes::findOrFail($id);
        //var_dump($vendedor);
        return view('clientes.delete', ['clientes' => $clientes]);

    }
    public function destroy($id){

        $clientes = Clientes::findOrFail($id);
        $clientes -> delete();
        return "Excluido com sucesso";

    }


}
