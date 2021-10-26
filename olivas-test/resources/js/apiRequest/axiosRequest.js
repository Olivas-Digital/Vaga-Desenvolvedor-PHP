window.axiosRequest = (method = 'get', endpoint = '/', requestData, headers = { 'content-type': 'application/json' }) => {
  return axios({
    method: method,
    headers: headers,
    url: UISelect.baseUrl() + endpoint,
    data: requestData
  });
}
