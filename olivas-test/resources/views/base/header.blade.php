<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0" data-js="nav-bar-options">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{route('vendedores.show')}}">Vendedores</a>
        </li>
        <li class="nav-item logged-control">
          <a class="nav-link" href="{{route('clientes.show')}}">Clientes</a>
        </li>

        <li class="nav-item user-create-link">
          <a class="nav-link" href="{{route('users.create')}}">Cadastrar-se</a>
        </li>

        <li class="nav-item dropdown logged-control">
          <a class="create-drop-down nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Criar</a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="{{route('vendedores.create')}}">Vendedores</a></li>
            <li><a class="dropdown-item" href="{{route('clientes.create')}}">Clientes</a></li>
          </ul>
        </li>

        <li class="nav-item dropdown" data-js="user-drop-down">
          <a class="create-drop-down nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">User</a>
        </li>

      </ul>
    </div>
  </div>
</nav>