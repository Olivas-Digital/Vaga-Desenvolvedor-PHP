window.fetchResultDataFor = async (callBack, endPoint = '/', dataParams = false, headers) => {
  if (window.runQuery) return;
  window.runQuery = true;
  return axiosRequest('get', endPoint, dataParams, {
      'Authorization': userAuthToken(),
      'content-type': 'multipart/form-data'
    }
  )
    // .then(console.log)
    .then(({ data }) => {
      let { links } = data.data;
      let resultsData = data.data.data;
      return callBack(resultsData, links);
    })
    .catch(console.log)
    .finally(() => {
      window.runQuery = false;
    })
}