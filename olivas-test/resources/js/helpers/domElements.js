window.qSelect = (selector) => document.querySelector(selector);
window.qSelectAll = (selector) => document.querySelectorAll(selector);

window.removeElementFromDom = (elementSearch) => {
  let element = document.querySelector(elementSearch);
  return element ? element.remove() : false;
};

window.elContainClass = (e, className) => e.classList.contains(className); 

window.createHtmlElement = (elToCreate, ...attributes) => {
  let el = document.createElement(elToCreate);
  attributes.forEach(([key, value]) => el.setAttribute(key, value));
  return el;
}

