@extends('base/index')

@section('content')

<div class="search-container">
  <h1 class="form-title">Lista pública de Vendedores</h1>
  <form method="GET" action="{{route('seller.index')}}" class="search-form" data-js="search-seller-form">
    <input class="form-control" type="text" name="search" value="" placeholder="Digite o nome de um vendedor">
  </form>
</div>

@include('sellers/imports/sellerEditModal')

@endSection