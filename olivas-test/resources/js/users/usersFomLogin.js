const activeUserForm = () => {
  if (!UISelect.userFormLogin()) return;

  UISelect.userFormLogin().addEventListener('submit', e => {
    e.preventDefault();

    let[, email, password] = e.target;

    if (window.runQuery) return;
    window.runQuery = true;

    let objData = {
      email: email.value,
      password: password.value,
    };

    let formData = createFormDataObj(objData);

    axios.post(`${apiSelect.usersLoginPath}`, formData, { headers: { 'content-type': 'application/json' } })
      // .then(console.log)
      .then((res) => {
        const tokenType = res.data.token_type;
        const accessToken = res.data.access_token;
        // Save auth token to localStorage
        saveToLocalStorage('auth_token', `${tokenType} ${accessToken}`)
        
        swal({
          title: 'Opá, deu bom!', 
          text: 'Usuário foi logado!',
          icon: "success",
          button: "Ok",
        }).then(() => redirectTo('/clientes'));
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

activeUserForm();