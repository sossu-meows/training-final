/** Get webconfig for js */
// eslint-disable-next-line no-undef
const { wpConfig } = eli;

const APP_CONFIG = window.APP_CONFIG = {
  [process.env.NODE_ENV]: true,
  env: process.env.NODE_ENV,
  assetsPath: wpConfig.feAssetsUrl,
  publicPath: wpConfig.feAssetsUrl.replace('assets', './'),
  wpConfig,
};

// eslint-disable-next-line no-undef
__webpack_public_path__ = APP_CONFIG.publicPath;

export default APP_CONFIG;

