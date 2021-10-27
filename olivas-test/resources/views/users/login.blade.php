@extends('base/index')

@section('content')

<div class="send-form-container">
  <h1 class="form-title">Logar no sistema</h1>
  <form method="post" action="{{route('user.login')}}" class="search-form send-form" data-js="user-form-login">
    @csrf
    <div class="form-group">
      <label for="email" class="form-label">E-mail</label>
      <input type="email" name="email" value="" id="email" class="form-control" placeholder="Digite o email">
    </div>
    <div class="form-group">
      <label for="email" class="form-label">Senha</label>
      <input type="password" name="password" value="" id="password" class="form-control" placeholder="Digite a senha">
    </div>
    <input type="submit" value="Registrar" class="btn btn-success">
  </form>
</div>

@endSection