const optimizedResize = (function () {
  const callbacks = [];
  let running = false;

  // run the actual callbacks
  function runCallbacks() {
    callbacks.forEach((callback) => {
      callback();
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
  function resize() {
    if (!running) {
      running = true;

      if (requestAnimationFrame) {
        requestAnimationFrame(runCallbacks);
      } else {
        setTimeout(runCallbacks, 66);
      }
    }
  }

  return {
    // public method to add additional callback
    add(callback) {
      if (!callbacks.length) {
        window.addEventListener('resize', resize);
      }
      return addCallback(callback);
    },
  };
}());

export function onResize(callback) {
  return optimizedResize.add(callback);
}

// width resize
let callbacks;
let lastWidth;
let registerNativeResize;

function handler() {
  if (lastWidth && lastWidth !== window.innerWidth) {
    callbacks.forEach(cb => cb.apply());
  }
  lastWidth = window.innerWidth;
}

export function onWidthResize(callback) {
  if (!callbacks) {
    callbacks = [];
  }
  if (!registerNativeResize) {
    registerNativeResize = onResize(handler);
  }
  const id = callbacks.length - 1;
  callbacks.push(callback);
  return {
    remove: () => callbacks.splice(id, 1),
  };
}
