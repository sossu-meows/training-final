export function setupPlugin(pluginName, ComponentClass) {
  $.fn[pluginName] = function (options, params) {
    return this.each(function () {
      const $this = $(this);
      const htmlProps = $this.data();
      const instance = $this.data(pluginName);

      if (!instance) {
        $this.data(pluginName, new ComponentClass(this, {
          ...htmlProps,
          ...options,
        }));

        $this.on('destroy', () => {
          $this.data(pluginName, null);
        });
      } else if (instance[options]) {
        instance[options](params);
      }
    });
  };
}
