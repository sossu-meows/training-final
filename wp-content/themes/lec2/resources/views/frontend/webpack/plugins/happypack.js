const HappyPack = require('happypack');

function happyPack(original, id = Date.now().toString()) {
  return {
    loader: `happypack/loader?id=${id}`,
    plugin: new HappyPack({
      id,
      verbose: true,
      threads: 10,
      loaders: Array.isArray(original) ? original : [original],
    }),
  };
}

module.exports = happyPack;
