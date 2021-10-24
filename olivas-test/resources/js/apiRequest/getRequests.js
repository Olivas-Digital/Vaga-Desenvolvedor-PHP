window.getResults = (endpoint = '/', data) => {
  let queryString = data ? mountQueryString(data) : '';
  return axios.get(`${UISelect.baseUrl()}${endpoint}${queryString}`);
}

window.fetchResultDataFor = async (callBack, endPoint = '/', dataParams = false) => {
  return getResults(endPoint, dataParams)
    // .then(console.log)
    .then(({ data }) => {
      let { links } = data.data;
      let resultsData = data.data.data;
      return callBack(resultsData, links);
    })
    .catch(console.log)
}