window.UISelect = {
  baseUrl: () => qSelect('[data-base-url]').dataset.baseUrl,
  dataSellers: () => qSelectAll('[data-page-seller-id]'),
  sellerSearchForm: () => qSelect('[data-js="search-seller-form"]'),
  sellerCreateForm: () => qSelect('[data-js="create-seller-form"]'),
};