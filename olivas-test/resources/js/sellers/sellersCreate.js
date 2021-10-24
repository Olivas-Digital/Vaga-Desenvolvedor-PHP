import swal from 'sweetalert';

window.sellersCreate = () => {
  if (!UISelect.sellerCreateForm()) return;
  UISelect.sellerCreateForm().addEventListener('submit', (e) => {
    e.preventDefault();
    let [, name, tradeName] = e.target;

    axiosRequest('post', '/api/vendedores', {
      name: name.value,
      trade_name: tradeName.value
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