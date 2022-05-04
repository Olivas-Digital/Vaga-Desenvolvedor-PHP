@extends('base/index')

@section('content')

<div class="send-form-container">
  <h1 class="form-title">Criar Usuário</h1>
  <form method="post" action="{{route('user.register')}}" class="search-form send-form" data-js="user-form-create">
    @csrf
    <div class="form-group">
      <label for="name" class="form-label">Nome</label>
      <input type="text" name="name" value="" id="name" class="form-control" placeholder="Nome do usuário">
    </div>
    <div class="form-group">
      <label for="email" class="form-label">E-mail</label>
      <input type="email" name="email" value="" id="email" class="form-control" placeholder="Digite o email">
    </div>
    <div class="form-group">
      <label for="email" class="form-label">Senha</label>
      <input type="password" name="password" value="" id="password" class="form-control" placeholder="Digite a senha">
    </div>
    <div class="form-group">
      <label for="password_confirm" class="form-label">Confirmar senha</label>
      <input type="password" name="password_confirmation" value="" id="password_confirm" class="form-control" placeholder="Digite a confirmação">
    </div>
    <input type="submit" value="Registrar" class="btn btn-success">
  </form>
</div>

@endSection