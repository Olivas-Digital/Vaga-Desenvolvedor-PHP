@extends('base/index')

@section('content')

<h1>Registrar Cliente</h1>
<form method="post" action="{{route('client.store')}}" class="search-form" data-js="create-client-form">
  @csrf
  <input type="text" name="name" value="">
  <input type="text" name="email" value="">
  <!-- <input type="text" name="image" value=""> -->
  <input type="submit" value="Registrar">
</form>

@endSection