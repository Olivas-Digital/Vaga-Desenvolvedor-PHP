import swal from 'sweetalert';
import { hideModalBootstrapModal } from '../helpers/bootstrap';

window.clientsEdit = () => {
  if (!UISelect.clientsControls()) return;

  UISelect.clientsControls().forEach(clientControl => {

    clientControl.addEventListener('click', (e) => {
      e.preventDefault();
      let isEditEl = e.target.hasAttribute('data-client-edit');
      if (!isEditEl) return;

      let dataId = e.target.getAttribute('data-client-edit');
      let name = UISelect.clientName(dataId).innerText;
      let email = UISelect.clientEmail(dataId).innerText;

      // Remove all active elements
      removeClassFromElements(UISelect.clientItems(), 'active');
      // Add active to current client item
      addClassTo(UISelect.clientItem(dataId), 'active');

      if (UISelect.clientEditForm()) {
        showClientsEditForm(name, email);
      }
    });

  });
}

const showClientsEditForm = (name, email) => {
  UISelect.clientEditForm().reset();
  UISelect.clientFormName().value = name;
  UISelect.clientFormEmail().value = email;
  sendEditForm();
}

const sendEditForm = () => {
  UISelect.clientEditForm().addEventListener('submit', (e) => {
    e.preventDefault()
    hideModalBootstrapModal('#client-edit-modal');

    let name = UISelect.clientFormName().value;
    let email = UISelect.clientFormEmail().value;
    let clientId = UISelect.clientItemActive().getAttribute('data-client-item-id');

    if (window.runQuery) return;
    window.runQuery = true;
    axiosRequest('put', `${apiSelect.clientsPath}${clientId}`, {
      name: name,
      email: email
    })
      // .then(console.log)
      .then((res) => {
        swal({
          title: 'Opá, deu bom!', text: res.data.message, 
          icon: "success",
          button: "Ok",
        }).then(() => fetchClientsResult());
      })
      .catch(({ response }) => {
        let sweetObj = { title: 'Opá, deu ruim!', text: response.data.message + '\n', icon: "error", button: "Ok", };

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

  });
}


clientsEdit();
