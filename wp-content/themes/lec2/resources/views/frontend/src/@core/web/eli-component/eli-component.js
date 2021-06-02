const eliComponentExampleOptions = {
  // Selector to apply plugin
  selector: '.js-*',
};

/**
 * Decorator for eli-component
 *
 * @param {object} options please view eliComponentExampleOptions
 */
export default function (options) {
  return (ComponentClass) => {
    ComponentClass.initEliComponent = () => {
      const $components = $(options.selector);
      $components.each((index, element) => {
        const component = (new ComponentClass(element));
        component.init();
      });
    };

    return ComponentClass;
  };
}
