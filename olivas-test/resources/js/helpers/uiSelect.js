window.UISelect = {
  // Base
  baseUrl: () => qSelect('[data-base-url]').dataset.baseUrl,
  // Users
  userFormCreate: () => qSelect('[data-js="user-form-create"]'),
  userFormLogin: () => qSelect('[data-js="user-form-login"]'),
  // Sellers
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
  // Clients
  dataClients: () => qSelectAll('[data-page-client-id]'),
  clientSearchForm: () => qSelect('[data-js="search-client-form"]'),
  clientCreateForm: () => qSelect('[data-js="create-client-form"]'),
  clientsControls: () => qSelectAll('[data-js="client-controls"]'),
  clientItem: (id) => qSelect(`[data-client-item-id="${id}"]`),
  clientItems: () => qSelectAll(`[data-client-item-id]`),
  clientItemActive: () => qSelect(`[data-client-item-id].active`),
  clientName: (id) => qSelect(`[data-js="client-name-${id}"]`),
  clientEmail: (id) =>
    qSelect(`[data-js="client-email-${id}"]`),
  clientEditForm: () => qSelect('[data-js="client-edit-form"]'),
  clientFormName: () => qSelect('#client-name'),
  clientFormEmail: () => qSelect('#client-email'),
};