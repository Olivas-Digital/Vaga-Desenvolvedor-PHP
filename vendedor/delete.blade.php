<div class="d-inline-flex bg-dark p-3 py-4">
<p class="text-light">Nome: {{ $vendedor->nome }}</p>
<p class="text-light">Email: {{ $vendedor->email }}</p>

<div class="d-inline-flex bg-dark p-3 py-4">
        <form method="POST" action="{{ route('excluir_vendedor' , ['id' => $vendedor ->id]) }}">
        @csrf <!-- {{ csrf_field() }} -->
        <p class="text-light">Tem certeza que quer deletar esse usuario?</p>
        <input type="submit" value="SIM" class="btn btn-primary">
        </form>
        </div>
</div>