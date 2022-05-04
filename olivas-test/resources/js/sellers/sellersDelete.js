import swal from 'sweetalert';

window.sellersDelete = () => {
  if (!UISelect.sellersControls()) return;

  UISelect.sellersControls().forEach(sellerControl => {

    sellerControl.addEventListener('click', (e) => {
      e.preventDefault();

      let isRemoveEl = e.target.hasAttribute('data-seller-delete');
      if (!isRemoveEl) return;

      let dataId = e.target.getAttribute('data-seller-delete');
      // Remove all active elements
      removeClassFromElements(UISelect.sellerItems(), 'active');
      // Add active to current seller item
      addClassTo(UISelect.sellerItem(dataId), 'active');

      swal("Esta operação é irreversivel", {
        icon: "warning",
        title: "Quer mesmo deletar?",
        dangerMode: true,
        buttons: { cancel: { text: "Cancelar", value: null, visible: true, className: "", closeModal: true }, confirm: { text: "Sim!", value: true, visible: true, className: "", closeModal: true } },
      })
        .then(answer => answer ?
          sellersDeleteSend(dataId) : false);
    });

  });
}

const sellersDeleteSend = (id) => {
  if (window.runQuery) return;
  window.runQuery = true;
  axiosRequest('delete', `/api/vendedores/${id}`)
    // .then(console.log)
    .then((res) => {
      swal({
        title: 'Opá, deletado!',
        text: res.data.message,
        icon: "success",
        button: "Ok",
      }).then(() => fetchSellersResult());
    })
    .catch(({ response }) => {
      let sweetObj = {
        title: 'Opá, deu ruim!',
        text: response.data.message + '\n',
        icon: "error",
        button: "Ok",
      };

      let errors = response.data.errors;
      if (errors) {
        sweetObj.title = response.data.message;
        sweetObj.text = convertObjToString(errors);
      }
      swal(sweetObj);
    })
    .finally(() => {
      window.runQuery = false;
    })
}
