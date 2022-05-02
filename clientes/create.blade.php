@extends('global')




@section('titulo')
                Criar Cliente
@stop



@section('conteudo')

        <div class="row">
            <div class="d-inline-flex bg-dark p-3 py-4 justify-content-center" style="zoom: 150%;"> 
            <form method="POST" action="{{ route('registrar_cliente') }}">
            @csrf <!-- {{ csrf_field() }} -->
            <p class="text-light">Insira os dados do cliente para salvar:</p>
            <input type="text" name="nome" class="form-control mb-2" placeholder="Digita seu Nome" required />
            <input type="text" name="email" class="form-control mb-2" placeholder="Digita seu Email" required />
            <input type="text" name="imagem" class="form-control mb-2" placeholder="Digite uma URL para a imagem" required />
            <input type="text" name="telefone" class="form-control mb-2" placeholder="Digite seu telefone" required />
            <input type="text" name="tipocliente" class="form-control mb-2" placeholder="Tipo de cliente" required />
            <input type="number" min="0" step="1" name="idvendedor" class="form-control mb-2" placeholder="ID do Vendedor" required />
            <input type="submit" value="Salvar" class="btn btn-primary">
            </form>
            </div>
        </div>

@stop
