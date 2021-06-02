
function map(target, callback) {
  return Object.entries(target).map(([key, val], i) => callback(val, key, i));
}

function isObject(data) {
  if ((typeof data === 'object') && (data !== null)) {
    return true;
  }
  return false;
}

function log(param) {
  const json = JSON.stringify(param);

  return `
    <script> console.log('%c SERVER LOG:', 'color:blue;font-weight:bold;', ${json}); </script>
  `;
}

const catchAll = (func) => {
  try {
    return func();
  } catch (error) {
    console.error('\n');
    throw error;
  }
};

/**
 * Travel through all nested field of object to perform an action
 * @param {object} data object need to be travel
 * @param {function} cb : will be invoke on every nested field
 */
function nestedMap(data, cb) {
  map(data, (v, key) => {
    cb(v, key, data);
    if (isObject(v) || Array.isArray(v)) {
      nestedMap(v, cb);
    }
  });
}


function toCapitalize(str) {
  return str.replace(/\b\w/g, l => l.toUpperCase());
}

function getFeAssetsUrl(config) {
  return `${config.build.publicPath}assets`.replace('//', '/');
}

function camelToSlug(str) {
  return str.replace(/([a-z0-9])([A-Z])/g, (regex, s1, s2) => {
    return `${s1}-${s2.toLowerCase()}`;
  });
}

function merge(t, s) {
  // Do nothing if they're the same object
  if (t === s) {
    return;
  }

  // Loop through source's own enumerable properties
  Object.keys(s).forEach((key) => {
    // Get the value
    const val = s[key];

    // Is it a non-null object reference?
    if (val !== null && typeof val === 'object') {
      // Yes, if it doesn't exist yet on target, create it
      // eslint-disable-next-line no-prototype-builtins
      if (!t.hasOwnProperty(key)) {
        t[key] = {};
      }

      // Recurse into that object
      merge(t[key], s[key]);

      // Not a non-null object ref, copy if target doesn't have it
      // eslint-disable-next-line no-prototype-builtins
    } else {
      t[key] = s[key];
    }
  });
}

module.exports = {
  nestedMap,
  log,
  catchAll,
  toCapitalize,
  getFeAssetsUrl,
  camelToSlug,
  merge,
};

