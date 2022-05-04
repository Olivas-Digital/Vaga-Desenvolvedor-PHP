const activeUserForm = () => {
  if (!UISelect.userFormCreate()) return;

  UISelect.userFormCreate().addEventListener('submit', e => {
    e.preventDefault();

    let[, name, email, password, password_confirmation] = e.target;

    if (window.runQuery) return;
    window.runQuery = true;

    let objData = {
      name: name.value,
      email: email.value,
      password: password.value,
      password_confirmation: password_confirmation.value,
    };

    let formData = createFormDataObj(objData);

    axios.post(`${apiSelect.usersCreatePath}`, formData, { headers: { 'content-type': 'application/json' } })
      // .then(console.log)
      .then((res) => {
        swal({
          title: 'Opá, deu bom!', text: res.data.message,
          icon: "success",
          button: "Ok",
        }).then(() => redirectTo('/clientes'));
      })
      // .catch(console.log)
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

activeUserForm();