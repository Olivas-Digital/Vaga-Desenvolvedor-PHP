<div class="d-inline-flex bg-dark p-3 py-4">
<p class="text-light">Nome: {{ $vendedor->nome }}</p>
<p class="text-light">Email: {{ $vendedor->email }}</p>

<div class="d-inline-flex bg-dark p-3 py-4">
        <form method="POST" action="{{ route('alterar_vendedor' , ['id' => $vendedor ->id]) }}">
        @csrf <!-- {{ csrf_field() }} -->
        <p class="text-light">Alterar dados do vendedor?</p>
        <input type="text" name="nome" class="form-control mb-2" placeholder="{{ $vendedor->nome }}" required />
        <input type="text" name="email" class="form-control mb-2" placeholder="{{ $vendedor->email }}" required />
        <input type="submit" value="Atualizar" class="btn btn-primary">
        </form>
        </div>
</div>