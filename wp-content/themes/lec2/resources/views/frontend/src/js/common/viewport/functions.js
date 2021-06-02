import { TABLET_MAX_WIDTH, MOBILE_MAX_WIDTH } from './consts';
import { onResize } from '../../common/helpers/dom/resize';

function isTabletDown() {
  return window.innerWidth <= TABLET_MAX_WIDTH;
}

function isTabletUp() {
  return window.innerWidth > MOBILE_MAX_WIDTH;
}

function isMobile() {
  return window.innerWidth <= MOBILE_MAX_WIDTH;
}

function isTablet() {
  return window.innerWidth <= TABLET_MAX_WIDTH && window.innerWidth > MOBILE_MAX_WIDTH;
}

function isDesktop() {
  return window.innerWidth > TABLET_MAX_WIDTH;
}

function width() {
  return window.innerWidth;
}

function height() {
  return window.innerHeight;
}

function device() {
  // eslint-disable-next-line no-nested-ternary
  return isMobile() ? 'mobile' : isTablet() ? 'tablet' : 'desktop';
}

function getHeaderHeight() {
  const $wpadminbar = $('#wpadminbar');
  const siteHeaderHeight = $('.site-header').height();
  return $wpadminbar.length ? siteHeaderHeight + $wpadminbar.height() : siteHeaderHeight;
}

export function checkViewport() {
  const deviceChangeListeners = [];
  const res = {};

  res.onDeviceChange = handler => deviceChangeListeners.push(handler);

  function updateViewportData() {
    const lastDevice = res.device;

    const functions = {
      isTabletDown,
      isTabletUp,
      isMobile,
      isDesktop,
      isTablet,
      width,
      device,
      height,
      headerHeight: getHeaderHeight,
    };

    Object.entries(functions).map(([key, value]) => (res[key] = value()));

    if (lastDevice && lastDevice !== res.device) {
      $(document).trigger('device:change', lastDevice, res.device);
      deviceChangeListeners.forEach(handler => handler(lastDevice, res.device));
    }
  }

  onResize(updateViewportData);

  updateViewportData();
  $(document).ready(() => {
    updateViewportData();
  });
  return res;
}
