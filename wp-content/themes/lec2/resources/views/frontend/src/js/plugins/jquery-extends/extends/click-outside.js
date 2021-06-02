function clickOutside() {
  const subscribers = [];
  const handledMarker = 'eli.clickOutside';

  $.fn.clickOutside = function (handler, options = {}) {
    this.each(function () {
      if (!subscribers.find(e => e.element === this)) {
        subscribers.push({
          element: this,
          handler: handler.bind(this),
          options,
        });
      }
    });
    return this;
  };

  const isSelfOrChildren = (selector, targetSelector) => $(selector).find(targetSelector).get(0) || $(targetSelector).is(selector);

  $(document).bind('click', (event) => {
    const originalEvent = event.originalEvent;
    const isHandled = originalEvent && originalEvent[handledMarker] === true;

    if (originalEvent && !isHandled) {
      originalEvent[handledMarker] = true;

      const $target = $(event.target);
      const isInIngoreList = e => e.options.ignore && isSelfOrChildren(e.options.ignore, $target);

      subscribers.filter((e) => {
        return !(isSelfOrChildren(e.element, $target) || isInIngoreList(e));
      })
        .forEach((e) => {
          e.handler({ ...event, currentTarget: e.element });
        });
    }
  });
}

// init clickout side
clickOutside();
