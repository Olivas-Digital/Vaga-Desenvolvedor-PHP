const generateClientsResultData = (results) => {
  removeElementFromDom('[data-js="clients-result"]');

  let resultsSection = createHtmlElement('section', ['class', 'clients-result'], ['data-js', 'clients-result']);
  results.map(({ id, name, email, image_path }) => {
    let buttons =
      `<div class='controls' data-js='client-controls'><button type="button" class="btn btn-warning" data-client-edit='${id}' data-bs-target="#client-edit-modal" data-bs-toggle="modal"><i class='bi bi-pencil-square'></i> Editar</button> <button type="button" class="btn btn-danger" data-client-delete='${id}'><i class="bi bi-trash-fill"></i> Deletar</button></div>`;
    let image = image_path != '' ? image_path : 'images/api/default/blackMagicianNo.gif';

    let item = `<div class='result-item' data-client-item-id='${id}'><figure data-js="client-figure-${id}"><img src='${UISelect.baseUrl()}/${image}' alt="${image_path}" title="${name}" data-js="client-img-${id}"></figure></figure><h3><span data-js="client-name-${id}">${name}<span></h3><p><span data-js="client-email-${id}">${email}<span></p>${buttons}</div>`

    return resultsSection.innerHTML += item;
  }).join('');
  return resultsSection;
}

const generateClientsPagination = (links, resultData) => {
  removeElementFromDom('[data-js="clients-pagination"]');

  const div = createHtmlElement('div', ['class', 'pagination clients-pagination'], ['data-js', 'clients-pagination']);

  let queryHasDataResults = resultData.length > 0;
  if (!queryHasDataResults) {
    div.innerHTML = '<p>Sem resultado para a busca</p>';
    return div;
  }

  let pageable = links.length !== 3;
  if (!pageable) {
    div.innerHTML = '';
    return div;
  }

  let linksGenerated = links.map(({ url, active, label }) => {
    let disable = url ? '' : "disable";
    let href = `href='${url ? url : 'javascript: void(0)'}'`;
    let activeEl = active ? 'active' : '';
    let clientId = getQueryParams('page', url);

    return `<a ${href} ${disable} class="client-page-item ${activeEl} ${disable}" data-page-client-id='${clientId}'>${label}</a>`;
  }).join('');

  div.innerHTML = linksGenerated;
  return div;
}

const generateResultsForClients = (resultsData, links) => {
  let resultData = generateClientsResultData(resultsData);
  let pagination = generateClientsPagination(links, resultsData);
  qSelect('main').appendChild(resultData);
  qSelect('main').appendChild(pagination);

  clickDataClients();
  clientsEdit();
  clientsDelete();
}

const getClientsEndPoint = () => {
  let urlPageParam = getQueryParams('page', getUrl());
  let urlSearchParam = getQueryParams('search', getUrl());
  let page = (urlPageParam ? `?page=${urlPageParam}` : '');
  let search = (urlSearchParam ? `&search=${urlSearchParam}` : '');
  return apiSelect.clientsPath + page + search;
}

window.fetchClientsResult = (data = false) => {
  const isInClientsPage = qSelect('[data-page="clients-paginate"]');

  if (!isInClientsPage) return;

  let clientsEndPoint = getClientsEndPoint();
  return fetchResultDataFor(generateResultsForClients, clientsEndPoint, data);
}

fetchClientsResult();

const clickDataClients = () => {
  // let clients = Array.from(UISelect.dataClients());
  let clients = UISelect.dataClients();
  clients.forEach(item =>
    item.onclick = e => {
      e.preventDefault();
      let isBtnDisable = elContainClass(e.target, 'disable');

      if (isBtnDisable) return;

      let clickedPage = e.target.getAttribute('data-page-client-id');

      history.pushState({ page: clickedPage }, "Clientes - pág: " + clickedPage, "?page=" + clickedPage);
      fetchClientsResult();
    });
}

window.onpopstate = function (event) {
  fetchClientsResult();
  let eventState = event.state.page;
  document.title = eventState ? "Clientes - pág: " + eventState : 'Clientes';
};

['submit', 'keyup'].forEach(listener => {
  let clientsForm = UISelect.clientSearchForm();
  if (!clientsForm) return;

  clientsForm.addEventListener(listener, e => {
    e.preventDefault();
    let searchedValue = e.target.value;

    let searchParamActive = searchedValue ? '&search=' + searchedValue : '';

    history.pushState({ page: 1 }, "Clientes - pág: " + 1, "?page=" + 1 + searchParamActive);
    return fetchClientsResult({ 'search': searchParamActive });
  });
}
)
