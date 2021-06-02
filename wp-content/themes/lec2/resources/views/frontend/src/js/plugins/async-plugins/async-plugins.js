import { map } from '@/js/common/helpers/functions';
import 'slick-carousel/slick/slick.min';
import 'bootstrap-select/dist/js/bootstrap-select';
import '../form-validator';

const asyncPluginLoader = {
  async formValidator() {
    await Promise.resolve(true);
  },
  async slick() {
    await Promise.resolve(true);
  },
  async selectpicker() {
    await Promise.resolve(true);
  },
};

export function initJqueryAsyncPlugin() {
  // apply fn.lazy
  $.fn.asyncPlugin = function (params = {}) {
    const $el = this;
    const proxyObject = {};

    map(asyncPluginLoader, (value, pluginName) => {
      const fakeFunction = async function (...args) {
        const loadFunction = asyncPluginLoader[pluginName];
        if (loadFunction) {
          try {
            if (params.showLoading) {
              $el.loading(true);
            }

            await loadFunction();
            if (params.showLoading) {
              $el.loading(false);
            }
            return $el[pluginName](...args);
          } catch (error) {
            console.error(error);
          }
        }
        throw new Error(`${pluginName} is not available in async plugins loader`);
      };
      proxyObject[pluginName] = fakeFunction;
    });
    return proxyObject;
  };
}

export default asyncPluginLoader;