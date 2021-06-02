const controllersDictionary = {
  global: require('@/views/pages/global/controller'),
};

const isClassModule = fn => /^.*_classCall/im.test(fn.toString());

/* Handling create controllers import paths.
 * Afther this all website js controllers will be added at controllersDictionary */
const contextRequire = require.context('@/views/pages', true, /\.\/([\w-]+)\/controller\/index.js$/);
contextRequire.keys().forEach((path) => {
  const pat = /\.\/([\w-]+).*$/;
  const controllerName = pat.exec(path)[1];
  // eslint-disable-next-line import/no-dynamic-require
  controllersDictionary[controllerName] = () => {
    const controllerData = contextRequire(path).default;
    const Controller = !isClassModule(controllerData) ? controllerData().then(res => res.default || res) : controllerData;
    return Controller;
  };
});

export async function getControllerClass(controllerName) {
  if (controllersDictionary[controllerName]) {
    const Controller = (await controllersDictionary[controllerName]());
    return Controller;
  }
  return null;
}

export default controllersDictionary;
