/**
 * debounce function
 * @param {function} func main function
 * @param {number} wait  time
 * @param {bool} immediate should call the first time
 */
export function debounce(func, wait, immediate) {
  let timeout;
  return function (...args) {
    const context = this;
    const later = function () {
      timeout = null;
      if (!immediate) func.apply(context, args);
    };
    const callNow = immediate && !timeout;
    clearTimeout(timeout);
    timeout = setTimeout(later, wait);
    if (callNow) func.apply(context, args);
  };
}

/**
 * loop and run callback
 * @param {object|array} target
 * @param {function} callback
 */
export function map(target, callback) {
  return Object.entries(target).map(([key, val], i) => callback(val, key, i));
}

/**
 * Make singleton class by adding Class.getInstance
 * @param {*} Component
 */
export function makeSingleton(Component) {
  Component.getInstance = () => {
    if (!Component._instance) {
      Component._instance = new Component();
    }
    return Component._instance;
  };
}

/**
 * Make array
 * @param {*} value
 */
export function makeArray(value) {
  return Array.isArray(value) ? value : [value];
}

/**
 * Loop on matched item of a regex pattern
 * @param {string} content content
 * @param {RegExp} pattern regex pattern
 * @param {function} callback callback on matched item
 */
export function regexMap(content, pattern, callback) {
  const matchers = content.match(pattern);

  // find $color hex variable
  if (matchers) {
    return matchers.map((str) => {
      pattern.lastIndex = 0;
      const groups = pattern.exec(str);
      return callback(groups);
    });
  }

  return [];
}

/**
 * scroll to an element
 * @param {string} elementSelector
 * @param {object} options
 */
export function scrollToElement(elementSelector, options = {}) {
  const top = $(elementSelector).offset().top + (options.offset || 0);
  $('html, body').animate({
    scrollTop: top,
  }, 600);
}
