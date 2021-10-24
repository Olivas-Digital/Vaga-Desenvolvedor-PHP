window.stringIncludes = (param, url) => {
  return url.includes(param);
}

window.convertObjToString = (obj, separator = '\n') => {
  return Object.values(obj).
    reduce((acc, crr) => acc += crr + separator, '');
}