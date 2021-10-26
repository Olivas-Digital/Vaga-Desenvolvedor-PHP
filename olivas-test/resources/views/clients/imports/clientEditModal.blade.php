<!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#client-edit-modal">Open modal for @mdo</button> -->

<div class="modal fade" id="client-edit-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar Cliente</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <form method="post" data-js="client-edit-form" action="/" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="mb-3">
            <label for="client-name" class="col-form-label">Nome:</label>
            <input type="text" class="form-control" id="client-name" value="">
          </div>
          <div class="mb-3">
            <label for="client-email" class="col-form-label">E-mail</label>
            <input type="text" class="form-control" id="client-email" value="">
          </div>

          <div id="drop-area" class="drop-area d-flex justify-content-center flex-column">
            <div class="my-form">
              <label for="fileInput-budget" class="d-block m-auto">
                <p class="m-0 text-center">Clique ou arraste um arquivo para a área de upload.</p>
              </label>
            </div>
            <input type="file" id="fileElem" class="fileInput form-control" style="margin: auto;opacity:0;" accept="image/*" onchange="handleFiles(this.files)">
            <div id="gallery"></div>
          </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>

        <button type="submit" class="btn btn-primary">Atualizar</button>
      </div>
      </form>
    </div>
  </div>
</div>
</div>