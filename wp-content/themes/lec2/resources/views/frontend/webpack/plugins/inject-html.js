/* eslint-disable import/no-dynamic-require */
/* eslint-disable consistent-return */
/**
 * Plugin help to append content hash query to output files, to avoid browser caching
 */
const path = require('path');
const glob = require('glob');
const fs = require('fs');
const config = require('../../config');

function getAssetsInfo(compilation) {
  const chunks = compilation.getStats().toJson().chunks;
  const compilationHash = compilation.hash;

  let publicPath = compilation.mainTemplate.getPublicPath({ hash: compilationHash });

  if (publicPath.length && publicPath.substr(-1, 1) !== '/') {
    publicPath += '/';
  }

  const assets = {
    publicPath,
    chunks: {},
    js: [],
    css: [],
  };
  for (let i = 0; i < chunks.length; i++) {
    const chunk = chunks[i];
    const chunkName = chunk.names[0];
    assets.chunks[chunkName] = {};
    // Prepend the public path to all chunk files
    const chunkFiles = [].concat(chunk.files).map(chunkFile => publicPath + chunkFile);

    // Webpack outputs an array for each chunk when using sourcemaps
    // or when one chunk hosts js and css simultaneously
    const js = chunkFiles.find(chunkFile => /.js($|\?)/.test(chunkFile));
    if (js) {
      assets.chunks[chunkName].size = chunk.size;
      assets.chunks[chunkName].entry = js;
      assets.chunks[chunkName].hash = chunk.hash;
      assets.js.push(js);
    }

    // Gather all css files
    const css = chunkFiles.filter(chunkFile => /.css($|\?)/.test(chunkFile));
    assets.chunks[chunkName].css = css;
    assets.css = assets.css.concat(css);
  }

  return {
    styles: assets.css || [],
    scripts: assets.js || [],
  };
}

async function readHTMLcontent(file) {
  return new Promise((resolve, reject) => {
    fs.readFile(file, 'utf8', (err, htmlContent) => {
      if (err) {
        return reject(err);
      }
      return resolve(htmlContent);
    });
  });
}

async function writeHTMLContent(file, htmlContent) {
  return new Promise((resolve, reject) => {
    fs.writeFile(file, htmlContent, 'utf8', (err) => {
      if (err) return reject(err);

      return resolve(true);
    });
  });
}

function getLinkBasic(link) {
  // remove query part
  const linkBasic = link.replace(/\?.*$/, '');
  return linkBasic;
}

/**
 * Convert regex string to regex object by escape special
 * @param {string} regexString
 */
function escapeRegExp(regexString) {
  return regexString.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'); // $& means the whole matched string
}

module.exports = async function injectAssetsToHTML({ compilation, options }) {
  try {
    const outputPath = compilation.options.output.path;
    const publicPath = compilation.options.output.publicPath;
    const assetsPath = `${publicPath}assets/`;
    const html = path.resolve(__dirname, `${outputPath}/*.html`);
    const { styles, scripts } = getAssetsInfo(compilation);
    const allAssets = [...styles, ...scripts];
    const htmlFiles = glob.sync(html);

    // Update asset version in HTML files
    const processes = htmlFiles.map(async (file) => {
      let htmlContent = await readHTMLcontent(file);

      allAssets.forEach((linkWebpack) => {
        const linkBasic = getLinkBasic(linkWebpack);
        if (htmlContent.includes(linkBasic)) {
          const regex = new RegExp((`${escapeRegExp(linkBasic)}(\\?v=.*?)?"`));
          htmlContent = htmlContent.replace(regex, `${linkWebpack}"`);
        }
      });
      await writeHTMLContent(file, htmlContent);
    });

    // Update assets config in assets.json
    try {
      const assetsJsonPath = `${config.root}/${config.assetsFile}`;
      const configAssets = require(assetsJsonPath);
      const distAssetsInfo = path.normalize(`${outputPath}/assets/${path.basename(config.assetsFile)}`);
      const { scripts, styles } = configAssets;

      // process links
      [scripts, styles].forEach((group) => {
        group.forEach((file, i) => {
          allAssets.forEach((link) => {
            const linkFromWebpack = link.replace(assetsPath, '');
            if (getLinkBasic(linkFromWebpack) === getLinkBasic(file)) {
              group[i] = linkFromWebpack;
            }
          });
        });
      });
      fs.writeFileSync(distAssetsInfo, JSON.stringify(configAssets, null, 2), 'utf8');
    } catch (err) {
      console.error(err);
    }
    await Promise.all(processes);
  } catch (err) {
    console.error(err);
  }
};
