@extends('base/index')

@section('content')

<h1>Lista pública de Vendedores</h1>
<form method="GET" action="{{route('seller.index')}}" class="search-form" data-js="search-seller-form">
  <input type="text" name="search" value="">
</form>

@include('sellers/imports/sellerEditModal')

@endSection