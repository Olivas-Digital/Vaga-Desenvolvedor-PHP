export const qSelect = (selector) => document.querySelector(selector);
export const qSelectAll = (selector) => document.querySelectorAll(selector);

export const elContainClass = (e, className) => e.classList.contains(className); 

export const createHtmlElement = (elToCreate, ...attributes) => {
  let el = document.createElement(elToCreate);
  attributes.forEach(([key, value]) => el.setAttribute(key, value));
  return el;
}

