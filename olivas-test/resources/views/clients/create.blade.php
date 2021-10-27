@extends('base/index')

@section('content')

<div class="send-form-container">
  <h1 class="form-title">Registrar Cliente</h1>
  <form method="post" action="{{route('client.store')}}" class="search-form send-form" data-js="create-client-form">
    @csrf
    <div class="form-group">
      <label for="name" class="form-label">Nome</label>
      <input type="text" name="name" value="" id="name" value="" placeholder="Digite o nome do cliente" class="form-control">
    </div>
    <div class="form-group">
      <label for="email" class="form-label">E-mail</label>
      <input type="text" name="email" value="" id="email" placeholder="Digite o e-mail do cliente" class="form-control">
    </div>
    <div id="drop-area" class="drop-area d-flex justify-content-center flex-column form-group">
      <div class="my-form">
        <label for="fileInput-budget" class="d-block m-auto">
          <p class="m-0 text-center">Clique ou arraste um arquivo para a área de upload.</p>
        </label>
      </div>
      <input type="file" id="fileElem" class="fileInput form-control" style="margin: auto;opacity:0;" accept="image/*" onchange="handleFiles(this.files)">
      <div id="gallery"></div>
    </div>
    <input type="submit" value="Registrar" class="btn btn-success">
  </form>
</div>

@endSection