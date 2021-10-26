window.createFormDataObj = obj => {
  let formData = new FormData();
  Object.entries(obj).forEach(item => {
    let [key, value] = item;
    return formData.append(key, value);
  });
  return formData;
}