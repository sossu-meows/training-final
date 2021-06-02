/* eslint-disable */

/**
 * Create plugin loader function
 *
 * @export
 * @param {*} pluginName
 * @param {*} $el
 * @param {*} params
 * @returns
 */
const loadedTracker = {};
export function getPluginLoaderFunction(pluginName, lazyLoadFunction) {
  const fakeFunction = async function (...args) {
    const $el = $(this);
    // If the plugin was loaded, just call it directly
    if (loadedTracker[pluginName]) {
      return $el[pluginName](...args);
    }

    if (lazyLoadFunction) {
      try {
        $el.loading(true);
        await lazyLoadFunction();
        $el.loading(false);
        // Now plugin is ready, let start
        if ($el[pluginName] && $el[pluginName] !== fakeFunction) {
          return $el[pluginName](...args);
        }
      } catch (error) {
        console.error(error);
      }
    }
    else {
      throw new Error(`${pluginName} is not available in async plugins loader`);
    }
  };
  return fakeFunction;
}
