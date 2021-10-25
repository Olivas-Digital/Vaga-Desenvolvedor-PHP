<!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#client-edit-modal">Open modal for @mdo</button> -->

<div class="modal fade" id="client-edit-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar Cliente</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post" data-js="client-edit-form" action="/">
          @csrf
          @method('PUT')
          <div class="mb-3">
            <label for="seller-name" class="col-form-label">Nome:</label>
            <input type="text" class="form-control" id="seller-name" value="">
          </div>
          <div class="mb-3">
            <label for="seller-trade-name" class="col-form-label">Nome fantasia</label>
            <input type="text" class="form-control" id="seller-trade-name" value="">
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