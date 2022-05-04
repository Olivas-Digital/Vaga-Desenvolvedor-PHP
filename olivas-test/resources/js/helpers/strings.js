window.stringIncludes = (string, param) => {
  return string.includes(param);
}

window.convertObjToString = (obj, separator = '\n') => {
  return Object.values(obj).
    reduce((acc, crr) => acc += crr + separator, '');
}