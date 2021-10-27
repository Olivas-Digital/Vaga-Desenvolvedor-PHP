window.axiosRequest = (method = 'get', endpoint = '/', requestData, headers = {
  'Authorization': userAuthToken(),
}) => {
  return axios({
    method: method,
    headers: headers,
    url: UISelect.baseUrl() + endpoint,
    data: requestData
  });
}
