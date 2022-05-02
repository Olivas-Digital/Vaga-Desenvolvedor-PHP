<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//Chama a classe de Vendedor da model para criar
use App\Models\Vendedor;




class VendedorController extends Controller
{
    //



        public function create(){

            return view('vendedor.create');

        }

        //CREATE (INSERT)
        public function store(Request $request){

            
            $nome = $request -> nome;
            $email = $request -> email;

            //FAZER VERIFICACOES ADICIONAIS , SE EMAIL É VALIDO ETC..
            //verifica se nome ou email existem e sao maiores que 4 chars
            if(strlen($nome)<4 && strlen($email)<4){

                return "Erro, seu nome e seu email sao invalidos tente de novo";
            }

                    //Chama a classe Vendedor que esta dentro da models/vendedor.php
                    Vendedor::create([
                        'nome' => $nome,
                        'email' => $email
                    ]);

                    return "Vendedor cadastrado com sucesso";
        }


        //READ (SELECT) 
        public function show($id){

            $vendedor = Vendedor::findOrFail($id);
            //var_dump($vendedor);
            return view('vendedor.show', ['vendedor' => $vendedor]);

        }


        //UPDATE (UPDATE) 
        public function editar($id){

            $vendedor = Vendedor::findOrFail($id);
            //var_dump($vendedor);
            return view('vendedor.editar', ['vendedor' => $vendedor]);

        }

        public function update(Request $request, $id){

            $vendedor = Vendedor::findOrFail($id);

            $vendedor ->update([
                'nome' => $request->nome,
                'email' => $request->email
            ]);

            return "Dados atualizados do vendedor com sucesso";

        }



         //DELETE 
         public function delete($id){

            $vendedor = Vendedor::findOrFail($id);
            //var_dump($vendedor);
            return view('vendedor.delete', ['vendedor' => $vendedor]);

        }
        public function destroy($id){

            $vendedor = Vendedor::findOrFail($id);
            $vendedor -> delete();
            return "Excluido com sucesso";

        }





}

