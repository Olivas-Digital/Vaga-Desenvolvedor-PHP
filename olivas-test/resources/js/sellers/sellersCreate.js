UISelect.sellerCreateForm().addEventListener('submit', (e) => {
  e.preventDefault();
  postRequest('/api/vendedores', {
      name: 'Marcos'
  })
  .then(console.log)
  .catch(console.log)
});