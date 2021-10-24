window.putRequest = (endpoint = '/', postData) => {
  return axios.put(`${UISelect.baseUrl()}${endpoint}`,
    postData
  );
}