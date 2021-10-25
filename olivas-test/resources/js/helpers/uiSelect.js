window.UISelect = {
  baseUrl: () => qSelect('[data-base-url]').dataset.baseUrl,
  dataSellers: () => qSelectAll('[data-page-seller-id]'),
  sellerSearchForm: () => qSelect('[data-js="search-seller-form"]'),
  sellerCreateForm: () => qSelect('[data-js="create-seller-form"]'),
  sellersControls: () => qSelectAll('[data-js="seller-controls"]'),
  sellerItem: (id) => qSelect(`[data-seller-item-id="${id}"]`),
  sellerItems: () => qSelectAll(`[data-seller-item-id]`),
  sellerItemActive: () => qSelect(`[data-seller-item-id].active`),
  sellerName: (id) => qSelect(`[data-js="seller-name-${id}"]`),
  sellerTradeName: (id) => 
    qSelect(`[data-js="seller-trade-name-${id}"]`),
  sellerEditForm: () => qSelect('[data-js="seller-edit-form"]'),
  sellerFormName: () => qSelect('#seller-name'),
  sellerFormTradeName: () => qSelect('#seller-trade-name'),
};