/* eslint-disable no-extend-native */

String.prototype.toCapitalize = function toCapitalize() {
  return this.replace(/\b\w/g, l => l.toUpperCase());
};

Array.prototype.sortBy = function (name, reverse = 1) {
  if (name) {
    return this.sort((a, b) => {
      if (a[name] < b[name]) { return -1 * reverse; }
      if (a[name] > b[name]) { return 1 * reverse; }
      return 0;
    });
  }
  return this;
};
