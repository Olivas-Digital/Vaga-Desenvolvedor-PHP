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

window.addClassTo = (el, className) =>
  el ? el.classList.add(className) : false;

window.removeClassTo = (el, className) =>
  el ? el.classList.remove(className) : false;

window.removeClassFromElements = (elements, className) =>
  elements ? Array.from(elements).forEach(el => removeClassTo(el, className)) : false;

window.removeAddClassForElement = (element, classToRemove = '', classToAdd = '', addStyle = null) => {
  if (!element) return;
  if (classToRemove != '') removeClassTo(element, classToRemove);
  if (classToAdd != '') addClassTo(element, classToAdd);
  if (addStyle != null) element.style = addStyle;
}

window.removeAddClassForElements = function (elements, classToRemove = '', classToAdd = '', addStyle = null) {
  elements.forEach((element) =>
    removeAddClassForElement(element, classToRemove, classToAdd, addStyle)
  );
}