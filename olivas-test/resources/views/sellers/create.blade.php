@extends('base/index')

@section('content')

<div class="send-form-container">
  <h1 class="form-title">Registrar Vendedor</h1>
  <form method="post" action="{{route('seller.store')}}" class="search-form send-form" data-js="create-seller-form" placeholder="Digite o nome do vendedor">
    @csrf
    <div class="form-group">
      <label for="name" class="form-label">Nome</label>
      <input type="text" name="name" value="" id="name" class="form-control">
    </div>
    <div class="form-group">
      <label for="trade_name" class="form-label">Nome Fantasia</label>
      <input type="text" name="trade_name" value="" id="trade_name" class="form-control">
    </div>
    <input type="submit" value="Registrar" class="btn btn-success">
  </form>
</div>

@endSection