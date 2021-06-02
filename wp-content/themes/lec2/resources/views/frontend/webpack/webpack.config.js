const path = require('path');
const webpack = require('webpack');
const autoprefixer = require('autoprefixer');
const CopyWebpackPlugin = require('copy-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const DelWebpackPlugin = require('del-webpack-plugin');
const OptimizeCSSAssetsPlugin = require('optimize-css-assets-webpack-plugin');
const UglifyJsPlugin = require('uglifyjs-webpack-plugin');
const PostCompile = require('post-compile-webpack-plugin');
const ImageminPlugin = require('imagemin-webpack-plugin').default;
const ProgressBarPlugin = require('progress-bar-webpack-plugin');
const IfPlugin = require('if-webpack-plugin');
const cssNano = require('cssnano');
const WebpackNotifierPlugin = require('webpack-notifier');
const getAdapterOptions = require('../src/@core/adapter');

// Analyzer dev only
const BundleAnalyzerPlugin = require('webpack-bundle-analyzer').BundleAnalyzerPlugin;

// HOC plugins
const happyPack = require('./plugins/happypack');
/**
 * Project config and directories
 */
const config = require('../config');

const src = `${config.root}/src`;
const outputDir = `${config.root}/${process.env.OUTPUT || config.build.outputDir}`;

const ico = path.resolve(src, 'ico/');
const views = path.resolve(src, 'views/');
const APP_ENV = process.env.NODE_ENV;

const isProduction = APP_ENV === 'production';
const isDevelopment = APP_ENV === 'development';
const isHotReload = process.env.HOT_DEV;

// Fix publicPath
config.build.publicPath = isHotReload ? '/' : config.build.publicPath;
const { publicPath } = config.build;

const queryVersion = isProduction ? '?v=[contenthash]' : '';
const sourceMap = isDevelopment;
const babelHappyPack = happyPack(['babel-loader', 'eslint-loader'], 'babel-js');

module.exports = {
  stats: {
    all: false,
    modules: true,
    maxModules: 0,
    errors: true,
    warnings: true,
    colors: true,
    moduleTrace: true,
    errorDetails: true,
  },
  context: src,
  entry: {
    vendors: [
      'babel-polyfill',
      'universal-fetch',
      'es6-promise/dist/es6-promise.auto.js',
      require.resolve('bootstrap/dist/js/bootstrap.bundle.min'),
      `${src}/js/plugins/nanobar`,
    ],
    app: `${src}/entry.js`,
    style: `${src}/@core/builder/index.js`,
  },
  output: {
    filename: `assets/js/[name].js${queryVersion}`,
    chunkFilename: `assets/js/chunks/[name].js${queryVersion}`,
    publicPath,
    path: outputDir,
  },
  resolve: {
    alias: {
      '@': src,
    },
  },
  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: /(node_modules)|(packages)|(bower_components)/,
        use: babelHappyPack.loader,
      },
      {
        test: /\.s?css/,
        use: [
          'css-hot-loader',
          {
            loader: MiniCssExtractPlugin.loader,
            options: {
              publicPath: '../../',
              sourceMap,
            },
          },
          {
            loader: 'css-loader',
            options: {
              sourceMap,
              minimize: !sourceMap,
            },
          },
          {
            loader: 'postcss-loader',
            options: {
              sourceMap: true,
              plugins: [cssNano({
                preset: 'default',
              }), autoprefixer],
            },
          },
          {
            loader: 'resolve-url-loader',
            options: {
              sourceMap: true,
            },
          },
          {
            loader: 'sass-loader',
            options: {
              sourceMap: true,
            },
          },
          {
            loader: 'import-glob-loader',
            options: {
              sourceMap: true,
            },
          },
        ],
      },
      {
        test: /\.(gif|png|jpe?g)$/,
        exclude: ico,
        use: [{
          loader: 'url-loader',
          options: {
            limit: 1024,
            name: 'assets/images/[name].[ext]',
          },
        }],
      },
      {
        test: /\.(svg|woff|eot|ttf|woff2)$/,
        exclude: ico,
        use: [{
          loader: 'url-loader',
          options: {
            limit: 1024,
            name: 'assets/fonts/[name].[ext]?hash=[contenthash:8]',
          },
        }],
      },
      {
        test: /\.svg$/,
        include: ico,
        use: ['svg-sprite-loader', 'svgo-loader'],
      },
      {
        test: /\.twig$/,
        include: views,
        use: [
          {
            loader: 'file-loader',
            options: {
              name: '[name].html',
              context: views,
            },
          },
          'extract-loader',
          {
            loader: 'html-loader',
            options: {
              minimize: isProduction,
              attrs: [],
            },
          },
          {
            loader: 'twig-html-loader',
            options: {
              namespaces: {
                views: `${src}/views`,
              },
              ...getAdapterOptions(config),
            },
          },
        ],
      },
    ],
  },
  devServer: {
    hot: true,
    port: config.devServer.port,
    overlay: true,
    disableHostCheck: true,
  },
  devtool: isProduction ? 'eval' : 'inline-source-map',
  optimization: {
    splitChunks: {
      name: 'manifest',
      minChunks: Infinity,
    },
    minimizer: [
      new UglifyJsPlugin({
        cache: true,
        parallel: true,
      }),
      new OptimizeCSSAssetsPlugin({}),
      new IfPlugin(
        config.build.optimizeImages,
        new ImageminPlugin({
          test: /\.(gif|png|jpe?g)$/,
        }),
      ),
    ],
  },
  externals: {
    jquery: 'jQuery',
  },
  plugins: [
    babelHappyPack.plugin,
    new webpack.DefinePlugin({
      'process.env.PUBLIC_PATH': JSON.stringify(publicPath),
      'process.env.NODE_ENV': JSON.stringify(APP_ENV),
    }),
    new webpack.ProvidePlugin({
      $: 'jquery',
      jQuery: 'jquery'
    }),
    new ProgressBarPlugin(),
    new MiniCssExtractPlugin({
      filename: `assets/styles/[name].css${queryVersion}`,
      chunkFilename: `assets/styles/_chunk-[name].css${queryVersion}`,
    }),
    new CopyWebpackPlugin(
      [
        {
          from: `${config.root}/public`,
          to: '.',
          toType: 'dir',
        },
        {
          from: `${src}/assets`,
          to: 'assets',
          toType: 'dir',
        },
      ],
    ),
    new IfPlugin(
      isProduction,
      new PostCompile(function (...args) {
        const func = require('./plugins/inject-html');
        func.apply(this, args);
      }),
    ),
    new WebpackNotifierPlugin({
      skipFirstNotification: true,
      excludeWarnings: true,
    }),
    // new IfPlugin(
    //   !isHotReload,
    //   new DelWebpackPlugin({
    //   }),
    // ),
    // new IfPlugin(
    //   isDevelopment,
    //   new BundleAnalyzerPlugin(),
    // ),
  ],
};
