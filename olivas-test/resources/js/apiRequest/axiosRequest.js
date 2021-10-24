window.axiosRequest = (method = 'get', endpoint, requestData) => {
  return axios({
    method: method,
    url: endpoint,
    data: requestData
  });
}
