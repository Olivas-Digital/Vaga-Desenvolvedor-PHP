import { qSelect, qSelectAll, elContainClass, createHtmlElement } from '../helpers/domElements';
import { getUrl, getQueryParams, mountQueryString } from '../helpers/url';

const UISelect = {
  baseUrl: () => qSelect('[data-base-url]').dataset.baseUrl,
  dataSellers: () => qSelectAll('[data-page-seller-id]'),
  sellerSearchForm: () => qSelect('[data-js="search-seller-form"]'),
};

const removeElementFromDom = (elementSearch) => {
  let element = document.querySelector(elementSearch);
  return element ? element.remove() : false;
};

const getResults = (endpoint = '/', data) => {
  let queryString = data ? mountQueryString(data) : '';
  return axios.get(`${UISelect.baseUrl()}${endpoint}${queryString}`);
}

const fetchResultDataFor = async (callBack, endPoint = '/', dataParams = false) => {
  return getResults(endPoint, dataParams)
    // .then(console.log)
    .then(({ data }) => {
      let { links } = data.data;
      let resultsData = data.data.data;
      return callBack(resultsData, links);
    })
    .catch(console.log)
}

const generateSellersResultData = (results) => {
  removeElementFromDom('[data-js="sellers-result"]');

  let resultsSection = createHtmlElement('section', ['class', 'sellers-result'], ['data-js', 'sellers-result']);
  resultsSection.innerHTML =
    results.map(({ id, name, trade_name }) =>
      `<div class='result-item' data-seller-id='${id}'><h3>${name}</h3><p>Nome Fantasia: ${trade_name}</p></div>`)
      .join('');
  return resultsSection;
}

const generateSellersPagination = (links) => {
  removeElementFromDom('[data-js="sellers-pagination"]');

  const div = createHtmlElement('div', ['class', 'pagination sellers-pagination'], ['data-js', 'sellers-pagination']);

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
  let pagination = generateSellersPagination(links);
  qSelect('main').appendChild(resultData);
  qSelect('main').appendChild(pagination);
  clickDataSellers();
}

const getSellersEndPoint = () => {
  let urlPageParam = getQueryParams('page', getUrl());
  return '/api/vendedores' + (urlPageParam ? `/?page=${urlPageParam}` : '');
}

const fetchSellersResult = (data = false) => {
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
};

['submit', 'keyup'].forEach(listener =>
  UISelect.sellerSearchForm()
    .addEventListener(listener, e => {
      e.preventDefault();
      let searchedValue = e.target.value;
      return fetchSellersResult({ 'search': searchedValue });
    })
)