import swal from 'sweetalert';


const sellersCreate = () => {
  if (!UISelect.sellerCreateForm()) return;

  UISelect.sellerCreateForm().addEventListener('submit', (e) => {
    e.preventDefault();
    postRequest('/api/vendedores', {
      name: 'Marcos',
      // trade_name: 'MSC'
    })
      // .then(console.log)
      .then((res) => {
        swal({
          title: 'Opá Deu Bom!',
          text: res.data.message,
          icon: "success",
          button: "Ok",
        }).then(() => redirectTo('/vendedores'));
      })
      .catch(({ response }) => {
        let sweetObj = {
          title: 'Opá Deu Ruim!',
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
  });
}

sellersCreate();
