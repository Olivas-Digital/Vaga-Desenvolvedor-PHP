export const hideModalBootstrapModal = (modalId) => {
  const selectedModal = qSelect(modalId);
  const modal = bootstrap.Modal.getInstance(selectedModal);
  return modal.hide();
}