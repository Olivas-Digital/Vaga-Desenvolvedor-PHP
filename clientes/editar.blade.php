<div class="d-inline-flex bg-dark p-3 py-4">
<p class="text-light">Nome: {{ $clientes->nome }}</p>
<p class="text-light">Email: {{ $clientes->email }}</p>

<div class="d-inline-flex bg-dark p-3 py-4">
        <form method="POST" action="{{ route('alterar_cliente' , ['id' => $clientes ->id]) }}">
        @csrf <!-- {{ csrf_field() }} -->
        <p class="text-light">Alterar dados do cliente?</p>
        <input type="text" name="nome" class="form-control mb-2" placeholder="{{ $clientes->nome }}" required />
        <input type="text" name="email" class="form-control mb-2" placeholder="{{ $clientes->email }}" required />
        <input type="text" name="imagem" class="form-control mb-2" placeholder="{{ $clientes->imagem }}" required />
        <input type="text" name="telefone" class="form-control mb-2" placeholder="{{ $clientes->telefone }}" required />
        <input type="text" name="tipocliente" class="form-control mb-2" placeholder="{{ $clientes->tipocliente }}" required/>
        <input type="number" min="0" step="1" name="vendedor" class="form-control mb-2" placeholder="{{ $clientes->vendedor }}" required />
        <input type="submit" value="Atualizar" class="btn btn-primary">
        </form>
        </div>
</div>