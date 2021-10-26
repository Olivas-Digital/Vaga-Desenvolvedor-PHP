@extends('base/index')

@section('content')

<h1>Criar Usuário</h1>
<form method="post" action="{{route('user.register')}}" class="search-form" data-js="user-form-create">
  @csrf
  <input type="text" name="name" value="">
  <input type="text" name="email" value="">
  <input type="password" name="password" value="">
  <input type="password" name="password_confirmation" value="">
  <input type="submit" value="Registrar">
</form>

@endSection