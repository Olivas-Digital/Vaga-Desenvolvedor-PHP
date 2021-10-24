window.postRequest = (endpoint = '/', postData) => {
  return axios.post(`${UISelect.baseUrl()}${endpoint}`,
    postData
  );
}