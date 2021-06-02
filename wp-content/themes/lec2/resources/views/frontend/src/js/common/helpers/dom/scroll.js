const optimizedScroll = (function () {
  const callbacks = [];

  let running = false;

  // run the actual callbacks
  function runCallbacks(event) {
    callbacks.forEach((callback) => {
      callback(event);
    });

    running = false;
  }

  // adds callback to loop
  function addCallback(callback) {
    if (callback) {
      callbacks.push(callback);
    }
    return {
      remove: () => {
        const id = callbacks.findIndex(c => c === callback);
        if (id !== -1) {
          callbacks.splice(id, 1);
        }
      },
    };
  }
  // fired on resize event
  function scroll(event) {
    if (!running) {
      running = true;

      if (requestAnimationFrame) {
        requestAnimationFrame(() => runCallbacks(event));
      } else {
        setTimeout(() => runCallbacks(event), 66);
      }
    }
  }

  return {
    // public method to add additional callback
    add(callback, capture = false) {
      if (!callbacks.length) {
        window.addEventListener('scroll', scroll, capture);
      }
      return addCallback(callback);
    },
  };
}());

export function onScroll(callback, capture) {
  return optimizedScroll.add(callback, capture);
}
