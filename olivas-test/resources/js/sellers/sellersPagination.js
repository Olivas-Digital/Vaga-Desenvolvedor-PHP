const generateSellersResultData = (results) => {
  removeElementFromDom('[data-js="sellers-result"]');

  let resultsSection = createHtmlElement('section', ['class', 'sellers-result'], ['data-js', 'sellers-result']);
  results.map(({ id, name, trade_name }) => {
    let buttons =
      `<div class='controls' data-js='seller-controls'><button type="button" class="btn btn-warning" data-seller-edit='${id}' data-bs-target="#seller-edit-modal" data-bs-toggle="modal"><i class='bi bi-pencil-square'></i> Editar</button> <button type="button" class="btn btn-danger" data-seller-delete='${id}'><i class="bi bi-trash-fill"></i> Deletar</button></div>`;

    let itemControls = userAuthToken() ? buttons : '';

    let item = `<div class='result-item' data-seller-item-id='${id}'><div><h3 ><span data-js="seller-name-${id}">${name}<span></h3><p>Nome Fantasia: <span data-js="seller-trade-name-${id}">${trade_name}<span></p>${itemControls}</div>`

    return resultsSection.innerHTML += item;
  }).join('');
  return resultsSection;
}

const generateSellersPagination = (links, resultData) => {
  removeElementFromDom('[data-js="sellers-pagination"]');

  const div = createHtmlElement('div', ['class', 'pagination sellers-pagination'], ['data-js', 'sellers-pagination']);

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
    let sellerId = getQueryParams('page', url);

    return `<a ${href} ${disable} class="seller-page-item ${activeEl} ${disable}" data-page-seller-id='${sellerId}'>${label}</a>`;
  }).join('');

  div.innerHTML = linksGenerated;
  return div;
}

const generateResultsForSellers = (resultsData, links) => {
  let resultData = generateSellersResultData(resultsData);
  let pagination = generateSellersPagination(links, resultsData);
  qSelect('main').appendChild(resultData);
  qSelect('main').appendChild(pagination);

  clickDataSellers();
  sellersEdit();
  sellersDelete();
}

const getSellersEndPoint = () => {
  let urlPageParam = getQueryParams('page', getUrl());
  let urlSearchParam = getQueryParams('search', getUrl());
  let page = (urlPageParam ? `?page=${urlPageParam}` : '');
  let search = (urlSearchParam ? `&search=${urlSearchParam}` : '');
  return apiSelect.sellersPath + page + search;
}

window.fetchSellersResult = (data = false) => {
  const isInSellersPage = qSelect('[data-page="sellers-paginate"]');

  if (!isInSellersPage) return;

  let sellersEndPoint = getSellersEndPoint();
  return fetchResultDataFor(generateResultsForSellers, sellersEndPoint, data);
}

fetchSellersResult();

const clickDataSellers = () => {
  // let sellers = Array.from(UISelect.dataSellers());
  let sellers = UISelect.dataSellers();
  sellers.forEach(item =>
    item.onclick = e => {
      e.preventDefault();
      let isBtnDisable = elContainClass(e.target, 'disable');

      if (isBtnDisable) return;

      let clickedPage = e.target.getAttribute('data-page-seller-id');

      history.pushState({ page: clickedPage }, "Vendedores - pág: " + clickedPage, "?page=" + clickedPage);
      fetchSellersResult();
    });
}

window.onpopstate = function (event) {
  fetchSellersResult();
  let eventState = event.state.page;
  document.title = eventState ? "Vendedores - pág: " + eventState : 'Vendedores';
};

['submit', 'keyup'].forEach(listener => {
  let sellersForm = UISelect.sellerSearchForm();
  if (!sellersForm) return;

  sellersForm.addEventListener(listener, e => {
    e.preventDefault();
    let searchedValue = e.target.value;

    let searchParamActive = searchedValue ? '&search=' + searchedValue : '';

    history.pushState({ page: 1 }, "Vendedores - pág: " + 1, "?page=" + 1 + searchParamActive);
    return fetchSellersResult({ 'search': searchParamActive });
  });
}
)
