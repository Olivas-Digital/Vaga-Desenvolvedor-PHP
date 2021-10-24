window.fetchResultDataFor = async (callBack, endPoint = '/', dataParams = false) => {
  return axiosRequest('get', endPoint, dataParams)
    // .then(console.log)
    .then(({ data }) => {
      let { links } = data.data;
      let resultsData = data.data.data;
      return callBack(resultsData, links);
    })
    .catch(console.log)
}