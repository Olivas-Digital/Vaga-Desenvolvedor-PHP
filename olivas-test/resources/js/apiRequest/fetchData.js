window.fetchResultDataFor = async (callBack, endPoint = '/', dataParams = false) => {
  if (window.runQuery) return;
  window.runQuery = true;
  return axiosRequest('get', endPoint, dataParams)
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