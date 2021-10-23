export const getUrl = () => window.location.href;

export const getQueryParams = (params, url) => {
  let href = url;
  // this is an expression to get query strings
  let regexp = new RegExp('[?&]' + params + '=([^&#]*)', 'i');
  let qString = regexp.exec(href);
  return qString ? qString[1] : null;
};
