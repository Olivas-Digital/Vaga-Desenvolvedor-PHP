
window.refreshControls = () => {
  const authToken = userAuthToken();
  let userNameLogged = getFromLocalStorage('loggedUsername');
  let headerName = authToken && userNameLogged ?
    userNameLogged.split(' ')[0] : 'Logar';

  let loggedControls = qSelectAll('.logged-control');
  let userCreateLink = qSelect('.user-create-link');

  (authToken) ?
    removeAddClassForElements(loggedControls, 'd-none', 'active') : removeAddClassForElements(loggedControls, 'active', 'd-none');

  (authToken) ? addClassTo(userCreateLink, 'd-none')
    : removeClassTo(userCreateLink, 'd-none')

  appendUserDropDownToHeader(headerName, authToken);
}

const appendUserDropDownToHeader = (headerName, authUser) => {
  removeElementFromDom('[data-js="user-drop-down"]');
  let dropDown = createHtmlElement('li', ['class', 'drop-down-control nav-item dropdown'], ['data-js', "user-drop-down"]);

  let exit = `<a class="nav-link dropdown-toggle" href="#" id="userDropDown" role="button" data-bs-toggle="dropdown" aria-expanded="false">${headerName}</a><ul class="dropdown-menu" aria-labelledby="userDropDown"><li><a class="dropdown-item" href="${UISelect.baseUrl()}/api/logout" data-js="user-logout-item">Sair</a></li></ul>`;

  let login = `<a class="nav-link" href="${UISelect.baseUrl()}/login" id="userLogin">Login</a>`;

  dropDown.innerHTML = authUser ? exit : login;

  let navBarOptions = UISelect.userNavbarOptions();
  if (navBarOptions)
    navBarOptions.appendChild(dropDown);
  return dropDown
}

refreshControls();