@extends('base/index')

@section('content')

<h1>Registrar Vendedor</h1>
<form method="post" action="{{route('seller.store')}}" class="search-form" data-js="create-seller-form">
  <input type="text" name="name" value="">
  <input type="text" name="trade_name" value="">
  <input type="submit" value="Registrar">
</form>

@endSection