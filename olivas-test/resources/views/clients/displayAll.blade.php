@extends('base/index')

@section('content')

<div class="search-container">
  <h1 class="form-title">Lista de Clientes</h1>
  <form method="GET" action="{{route('client.index')}}" class="search-form" data-js="search-client-form">
    <input class="form-control" type="text" name="search" value="" placeholder="Pesquise por um cliente">
  </form>
</div>

@include('clients/imports/clientEditModal')

@endSection