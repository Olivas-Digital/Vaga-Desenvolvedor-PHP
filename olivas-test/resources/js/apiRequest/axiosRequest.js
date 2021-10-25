window.axiosRequest = (method = 'get', endpoint = '/', requestData) => {
  return axios({
    method: method,
    url: UISelect.baseUrl() + endpoint,
    data: requestData
  });
}
