const importFresh = require('./helpers/import-fresh');
const { getFeAssetsUrl, camelToSlug } = require('./helpers/adapter-functions');

function getAdapterOptions(config) {
  const feAssetsUrl = getFeAssetsUrl(config);
  return {
    // Add data and functions
    data(context) {
      context.addContextDependency(__dirname);
      const TwigAdapter = importFresh(require.resolve('./classes/TwigAdapter'));
      const adapter = new TwigAdapter({ context, config, feAssetsUrl });
      return adapter.getContext();
    },
    functions: {
      fe_assets(path) {
        return feAssetsUrl + path;
      },
      path(page, state) {
        const concatState = state ? `--${state}` : '';
        return `./${camelToSlug(page)}${concatState}.html`;
      },
      get_the_post_thumbnail_url(id) {
        return `${feAssetsUrl}/images/image-${id.toString().padStart(2, 0)}.png`;
      },
    },
    filters: {
      trans: (str) => {
        return `${str}${config.development ? '[t]' : ''}`;
      },
      content: str => str,
    },
  };
}

module.exports = getAdapterOptions;
