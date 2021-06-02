import { getControllerClass } from './dictionary';

/**
 * Load page controller by name
 * @param {controllerName} controllerName page controller name
 */
async function loadController(controllerName) {
  const time = Date.now();
  const [GlobalController, PageController] = await Promise.all([
    getControllerClass('global'),
    getControllerClass(controllerName),
  ]);

  // init global controller
  (new GlobalController()).init();

  if (PageController) {
    // init page controller
    (new PageController()).init();

    console.log(`- Loaded ${PageController.name || PageController.displayName} in ${Date.now() - time}ms`);
  } else if (controllerName) {
    throw new Error(`Couldn't find controller: ${controllerName}`);
  }
}
export default loadController;
