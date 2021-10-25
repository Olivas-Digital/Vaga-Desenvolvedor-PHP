import swal from 'sweetalert';

window.clientsDelete = () => {
  if (!UISelect.clientsControls()) return;

  UISelect.clientsControls().forEach(clientControl => {

    clientControl.addEventListener('click', (e) => {
      e.preventDefault();

      let isRemoveEl = e.target.hasAttribute('data-client-delete');
      if (!isRemoveEl) return;

      let dataId = e.target.getAttribute('data-client-delete');
      // Remove all active elements
      removeClassFromElements(UISelect.clientItems(), 'active');
      // Add active to current client item
      addClassTo(UISelect.clientItem(dataId), 'active');

      swal("Esta operação é irreversivel", {
        icon: "warning",
        title: "Quer mesmo deletar?",
        dangerMode: true,
        buttons: { cancel: { text: "Cancelar", value: null, visible: true, className: "", closeModal: true }, confirm: { text: "Sim!", value: true, visible: true, className: "", closeModal: true } },
      })
        .then(answer => answer ?
          clientsDeleteSend(dataId) : false);
    });

  });
}

const clientsDeleteSend = (id) => {
  if (window.runQuery) return;
  window.runQuery = true;
  axiosRequest('delete', `${apiSelect.clientsPath}${id}`)
    // .then(console.log)
    .then((res) => {
      console.log(res)
      swal({
        title: 'Opá, deletado!',
        text: res.data.message,
        icon: "success",
        button: "Ok",
      }).then(() => fetchClientsResult());
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
