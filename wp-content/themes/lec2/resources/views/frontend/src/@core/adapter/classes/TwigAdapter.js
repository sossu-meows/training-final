const path = require('path');
const fs = require('fs');
const importFresh = require('../helpers/import-fresh');
const {
  log,
  catchAll,
  nestedMap,
  toCapitalize,
  merge,
} = require('../helpers/adapter-functions');

const PAGE_DATA_ALIAS = {
  index: 'home',
};

class TwigAdapter {
  /**
   * Creates an instance of TwigAdapter.
   * @param {*} { context, publicPath } webpackContext, publicPath of current build
   */
  constructor({ context, config, feAssetsUrl }) {
    this.webpackContext = context;
    this.publicPath = config.build.publicPath;
    this.config = config;
    this.feAssetsUrl = feAssetsUrl;
    this.mockData = {};
  }

  /**
   * Twig template _context object
   */
  getContext() {
    const { __debug, wpDefaultFunctions, devFunctions } = this;

    // save mock data
    this.mockData = this.getMockData();

    return {
      ...this.mockData,
      ...wpDefaultFunctions,
      ...devFunctions,
      __debug,
    };
  }

  getTemplateName() {
    const { resourcePath } = this.webpackContext;
    const [, templateName] = /([^/\\]+)\.twig$/.exec(resourcePath);
    return templateName;
  }

  getMockData() {
    const global = this.global;
    const pagesFolder = `${this.config.root}/src/views/pages`;
    const finalPageName = this.getPageName();
    const templateName = this.getTemplateName();
    const pageFolder = `${pagesFolder}/${finalPageName}`;
    const dataFile = `${pageFolder}/${finalPageName}.json`;
    const templateData = this.getJsonData(dataFile) || {};
    const stateName = this.getStateName(templateName, templateData);
    const mockData = {
      global: {},
      page_data: {},
    };

    // Get state data
    let stateData = {};
    if (stateName) {
      const stateFile = `${pagesFolder}/demos/${stateName}.json`;
      stateData = this.getJsonData(stateFile);
      if (stateData) {
        this.addToWatch(stateFile);
      }
    }

    this.addToWatch(dataFile);

    // Merge default data and state data
    merge(mockData, templateData);
    merge(mockData, stateData);
    merge(mockData, { global });

    return mockData;
  }

  addToWatch(filePath) {
    const normalizedPath = path.normalize(filePath);
    this.webpackContext.addDependency(normalizedPath);
  }

  /**
   *  global variables following backend's data model
   *
   * @readonly
   * @memberof TwigAdapter
   */
  get global() {
    const globalFile = path.resolve(
      `${this.config.root}/src/views/pages/global/global.json`,
    );
    const data = this.getJsonData(globalFile);
    this.addToWatch(globalFile);
    return {
      is_adapter: true,
      fe_assets_url: this.feAssetsUrl,
      ...data.global,
    };
  }

  /**
   * Get page name of template which is being compiled by webpack
   * @returns {string} page
   * @memberof TwigAdapter
   */
  getPageName() {
    const templateName = this.getTemplateName();
    const statePage = /([\w-]+)--(.*)/;
    let finalPageName;

    if (statePage.test(templateName)) {
      finalPageName = statePage.exec(templateName)[1];
    } else {
      finalPageName = PAGE_DATA_ALIAS[templateName] || templateName;
    }

    return finalPageName;
  }

  /**
   * To add debug info
   *
   * @readonly
   * @memberof TwigAdapter
   */
  get __debug() {
    return {
      fileName: `${this.getPageName()}.twig`,
    };
  }

  /**
   * Get if twig file has state name to mock data, same as logged in, is admin...
   */
  getStateName(templateName, templateData) {
    const regexStateFileName = /([\w-]+)--(.*)/; // Example state file name: home--logged.twig
    let stateName;
    if (regexStateFileName.test(templateName)) {
      stateName = regexStateFileName.exec(templateName)[2];
    } else if (templateData.metadata) {
      stateName = templateData.metadata.state;
    }
    return stateName;
  }

  /**
   *
   * @param {string} dataFile json file, full path
   */
  getJsonData(dataFile) {
    const { feAssetsUrl } = this;
    let data = {};
    dataFile = path.normalize(dataFile);

    if (fs.existsSync(dataFile)) {
      data = catchAll(() => importFresh(dataFile));
      // process ~@/assets path
      nestedMap(data, (value, key, parent) => {
        if (typeof value === 'string' && value.includes('~@/assets')) {
          parent[key] = value.replace('~@/assets', feAssetsUrl);
        }
      });
    }
    return data;
  }

  /**
   * Add helpers function for development
   *
   * @readonly
   * @memberof TwigAdapter
   */
  get devFunctions() {
    const functionLog = this.config.env === 'development' ? log : () => {};
    return {
      log: functionLog,
    };
  }

  readAssetsInfo() {
    const assetsFile = path.join(this.config.root, this.config.assetsFile);
    const data = this.getJsonData(assetsFile);
    return data || {};
  }

  /**
   * Get mock page title
   */
  getMockPageTitle() {
    if (this.mockData.page_data) {
      return (
        this.mockData.page_data.page_title || this.mockData.page_data.post_title
      );
    }
    return this.mockData.global.page_title;
  }

  /**
   * Simulate the default functions of wordpress platform
   *
   * @readonly
   * @memberof TwigAdapter
   */
  get wpDefaultFunctions() {
    const adapter = this;
    const { scripts, styles } = this.readAssetsInfo();

    const wordpressFunctions = {
      wp_head() {
        let htmlStyles = [];

        // append styles
        if (Array.isArray(styles)) {
          htmlStyles = styles.map((src) => {
            return `<link rel="stylesheet" href="${`${adapter.feAssetsUrl}/${src}`}" type="text/css">`;
          });
        }

        const pageTitle = adapter.getTemplateName().replace(/-/g, ' ');
        const mockTitle = adapter.getMockPageTitle();
        const head = `
          <title>${adapter.config.websiteName} - ${
  mockTitle || toCapitalize(pageTitle)
}</title>
          <link href="./favicon.ico?v=1.0" rel="icon" type="image/x-icon"/>
          ${htmlStyles.join('')}
        `;

        return head;
      },
      language_attributes() {
        return 'lang="en"';
      },
      blog_info(info) {
        switch (info) {
          case 'charset':
            return 'UTF-8';
          default:
            break;
        }
        return '';
      },
      body_class(classes) {
        return `class="static-html twig-adatper ${classes}"`;
      },
      wp_nav_menu() {
        return '';
      },
      wp_footer() {
        let htmlScripts = [];

        // append styles
        if (Array.isArray(scripts)) {
          htmlScripts = scripts.map((src) => {
            return `<script src="${`${adapter.feAssetsUrl}/${src}`}"></script>`;
          });
        }

        if (adapter.config.env === 'development') {
          htmlScripts.unshift(
            `<script src="${`${adapter.feAssetsUrl}/js/style.js`}"></script>`,
          );
        }

        // Load external jquery for FE
        htmlScripts.unshift(
          `<script src="${`${adapter.feAssetsUrl}/js-plugins/jquery.js`}"></script>`,
        );

        return `
          <div id="adpterFooter"></div>
          ${htmlScripts.join('')}
        `;
      },
      /** Woo commerce functions */
      do_action(action_name) {
        return action_name;
      },
      do_shortcode(shorcode_name) {
        return shorcode_name;
      },
      get_products() {
      },
      esc_html_e(str, mode = 'woocommerce') {
        return str;
      },
    };

    return {
      ...wordpressFunctions,
      get site_description() {
        return `All around education for Lattice Technologies and Tools. This is the ${adapter.getPageName()} meta description. It's a part of the website. The meta description can be updated in the future.`;
      },
    };
  }
}

module.exports = TwigAdapter;
