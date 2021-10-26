@extends('base/index')

@section('content')

<h1>Registrar Cliente</h1>
<form method="post" action="{{route('client.store')}}" class="search-form" data-js="create-client-form">
  @csrf
  <input type="text" name="name" value="">
  <input type="text" name="email" value="">
  <div id="drop-area" class="drop-area d-flex justify-content-center flex-column">
    <div class="my-form">
      <label for="fileInput-budget" class="d-block m-auto">
        <p class="m-0 text-center">Clique ou arraste um arquivo para a área de upload.</p>
      </label>
    </div>
    <input type="file" id="fileElem" class="fileInput form-control" style="margin: auto;opacity:0;" accept="image/*" onchange="handleFiles(this.files)">
    <div id="gallery"></div>
  </div>
  <input type="submit" value="Registrar">
</form>

@endSection