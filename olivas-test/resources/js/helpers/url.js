window.getUrl = () => window.location.href;

window.getQueryParams = (params, url) => {
  // this is an expression to get query strings
  let regexp = new RegExp('[?&]' + params + '=([^&#]*)', 'i');
  let qString = regexp.exec(url);
  return qString ? qString[1] : null;
};

window.mountQueryString = (data) => {
  let isAlreadyQueryString = stringIncludes('?', getUrl());
  let queryStringSymbol = isAlreadyQueryString ? '&' : '?';

  let stringUrl = Object.entries(data).reduce((acc, crr) => {
    let [name, value] = crr;
    return acc += `${name}=${value}`;
  }, '');

  return queryStringSymbol + stringUrl;
}