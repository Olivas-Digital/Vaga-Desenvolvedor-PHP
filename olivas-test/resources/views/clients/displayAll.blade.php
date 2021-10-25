@extends('base/index')

@section('content')

<h1>Lista de Clientes</h1>
<form method="GET" action="{{route('client.index')}}" class="search-form" data-js="search-client-form">
  <input type="text" name="search" value="">
</form>

@include('clients/imports/clientEditModal')

@endSection