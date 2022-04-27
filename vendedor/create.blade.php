@extends('global')




@section('titulo')
                Criar Vendedor
@stop



@section('conteudo')
        <div class="row">
            <div class="d-inline-flex bg-dark p-3 py-4 justify-content-center" style="zoom: 150%;">
            <form method="POST" action="{{ route('registrar_vendedor') }}">
            @csrf <!-- {{ csrf_field() }} -->
            <p class="text-light">Insira os dados do vendedor para salvar:</p>
            <input type="text" name="nome" class="form-control mb-2" placeholder="Digita seu Nome" required/>
            <input type="text" name="email" class="form-control mb-2" placeholder="Digita seu Email" required />
            <input type="submit" value="Salvar" class="btn btn-primary">
            </form>
            </div>
        </div>

@stop

