import swal from 'sweetalert';
import { hideModalBootstrapModal } from '../helpers/bootstrap';

window.sellersEdit = () => {
  if (!UISelect.sellersControls()) return;

  UISelect.sellersControls().forEach(sellerControl => {

    sellerControl.addEventListener('click', (e) => {
      e.preventDefault();
      let isEditEl = e.target.hasAttribute('data-seller-edit');
      if (!isEditEl) return;

      let dataId = e.target.getAttribute('data-seller-edit');
      let name = UISelect.sellerName(dataId).innerText;
      let tradeName = UISelect.sellerTradeName(dataId).innerText;

      // Remove all active elements
      removeClassFromElements(UISelect.sellerItems(), 'active');
      // Add active to current seller item
      addClassTo(UISelect.sellerItem(dataId), 'active');

      if (UISelect.sellerEditForm()) {
        showSellersEditForm(name, tradeName);
      }
    });

  });
}

const showSellersEditForm = (name, tradeName) => {
  UISelect.sellerEditForm().reset();
  UISelect.sellerFormName().value = name;
  UISelect.sellerFormTradeName().value = tradeName;
  sendEditForm();
}

const sendEditForm = () => {
  UISelect.sellerEditForm().addEventListener('submit', (e) => {
    e.preventDefault()
    hideModalBootstrapModal('#seller-edit-modal');

    let name = UISelect.sellerFormName().value;
    let tradeName = UISelect.sellerFormTradeName().value;
    let sellerId = UISelect.sellerItemActive().getAttribute('data-seller-item-id');

    if (window.runQuery) return;
    window.runQuery = true;
    axiosRequest('put', `/api/vendedores/${sellerId}`, {
      name: name,
      trade_name: tradeName
    })
      // .then(console.log)
      .then((res) => {
        swal({
          title: 'Opá, deu bom!', text: res.data.message, 
          icon: "success",
          button: "Ok",
        }).then(() => fetchSellersResult());
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


sellersEdit();
