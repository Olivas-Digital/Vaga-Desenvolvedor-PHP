window.userAuthToken = () => {
  let authToken = getFromLocalStorage('auth_token');
  return (authToken != false || authToken != '') ? authToken : false;
}

window.ifMoAuthTokenRedirectToLogin = () => {
  const authToken = userAuthToken();
  if (!authToken) redirectTo('/login');
}