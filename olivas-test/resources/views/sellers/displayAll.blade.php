@php
$title = 'Vendedores';
$dataPage = 'sellers-paginate';
@endphp

@extends('base/index')

@section('content')

<h1>Sellers</h1>
<form method="GET" action="{{route('seller.index')}}" class="search-form" data-js="search-seller-form">
  <input type="text" name="search" value="">
</form>

@endSection