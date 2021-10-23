import { stringIncludes } from '../helpers/strings';

export const getUrl = () => window.location.href;

export const getQueryParams = (params, url) => {
  // this is an expression to get query strings
  let regexp = new RegExp('[?&]' + params + '=([^&#]*)', 'i');
  let qString = regexp.exec(url);
  return qString ? qString[1] : null;
};

export const mountQueryString = (data) => {
  let isAlreadyQueryString = stringIncludes('?', getUrl());
  let queryStringSymbol = isAlreadyQueryString ? '&' : '?';

  let stringUrl = Object.entries(data).reduce((acc, crr) => {
    let [name, value] = crr;
    return acc += `${name}=${value}`;
  }, '');

  return queryStringSymbol + stringUrl;
}