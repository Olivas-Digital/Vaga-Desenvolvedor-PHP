@extends('base/index')

@section('content')

<h1>Logar no sistema</h1>
<form method="post" action="{{route('user.login')}}" class="search-form" data-js="user-form-login">
  @csrf
  <input type="text" name="email" value="">
  <input type="password" name="password" value="">
  <input type="submit" value="Registrar">
</form>

@endSection