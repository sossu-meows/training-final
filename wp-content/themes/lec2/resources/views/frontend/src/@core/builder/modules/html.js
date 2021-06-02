// twig
import '@/views/pages/index.twig';
import { setupHTMLWatcher } from './helpers';


const pat = /\.\/([\w-]+)\/([\w-]+)\.twig$/;
const contextRequire = require.context('@/views/pages', true, /\.\/([\w-]+)\/([\w-]+)\.twig$/);

// IMPORT ALL TWIG PAGES
export const ALL_PAGES = contextRequire.keys().map(e => pat.exec(e)[2]);

// @Todo remve wp admin watcher when go live
if (module.hot) {
  console.log('- HTML Watcher enabled');
  setupHTMLWatcher();
}
