import swal from 'sweetalert';

window.clientsCreate = () => {
  if (!UISelect.clientCreateForm()) return;
  UISelect.clientCreateForm().addEventListener('submit', (e) => {
    e.preventDefault();
    let [, name, email] = e.target;

    if (window.runQuery) return;
    window.runQuery = true;
    
    axiosRequest('post', apiSelect.clientsPath, {
      name: name.value,
      email: email.value
    })
      .then((res) => {
        swal({
          title: 'Opá deu bom!',
          text: res.data.message,
          icon: "success",
          button: "Ok",
        }).then(() => redirectTo('/clientes'));
      })
      .catch(({ response }) => {
        let sweetObj = {
          title: 'Opá deu ruim!',
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

  });
}

clientsCreate();