window.activeLogout = () => {
  if (!UISelect.userLogoutItem()) return;

  UISelect.userLogoutItem().addEventListener('click', e => {
    e.preventDefault();

    if (window.runQuery) return;
    window.runQuery = true;
    console.log(userAuthToken());
    axios.post(`${apiSelect.usersLogout}`, {}, {
      headers: {
        'Authorization': userAuthToken(),
        'content-type': 'application/json',
      }
    })
      // .then(console.log)
      .then((res) => { })
      .finally(() => {
        swal({
          title: 'Opá, deu bom!',
          text: 'Usuário saiu!',
          icon: "success",
          button: "Ok",
        }).then(() => {
          removeFromLocalStorage('auth_token');
          removeFromLocalStorage('loggedUsername');
          refreshControls();
          redirectTo('/login')
          window.runQuery = false;
        });

      });

  });

}

activeLogout();