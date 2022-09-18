/**
 * ============================================================================
 * webpack.config.blocks
 *
 * @package
 * @since     0.1.0
 * @version   0.1.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2021 RIESTER
 * ==========================================================================
 */

// ======================= Import Vendor Dependencies ======================= //
const _ = require('lodash');
const path = require('path');
const { argv } = require('yargs');
const { mergeWithCustomize, customizeArray, mergeWithRules, unique } = require('webpack-merge');
const DependencyExtractionWebpackPlugin = require('@wordpress/dependency-extraction-webpack-plugin');
const webpack = require('webpack');
let wordPressConfig = require('@wordpress/scripts/config/webpack.config');
const ESLintPlugin = require('eslint-webpack-plugin');
const TerserPlugin = require('terser-webpack-plugin');
// ======================== Import Local Dependencies ======================= //

const { isEmpty, debug, env, filePaths } = require('./utils/utils');
let { startingPlugins, config, baseConfig, endingPlugins, isProduction } = require('./utils/config');

// =========================== Setup File Globals =========================== //

const buildWatch = !isEmpty(argv.watch);

// ============= Filter out unwanted items from Wordpress Config ============ //

wordPressConfig = _.pick(wordPressConfig, ['resolve']);

// Merge Wordpress Config and Base config
baseConfig = mergeWithRules({
    module: {
        rules: {
            test: 'match',
            use: {
                loader: 'match',
                options: 'replace',
            },
        },
    },
})(wordPressConfig, baseConfig);

// ========================== Start Webpack Config ========================== //

let webpackConfig = {
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: [/node_modules/, /vendor/],
                use: [
                    {
                        loader: 'babel-loader',
                        options: {
                            envName: env(),
                            babelrc: false,
                            configFile: false,
                            targets: '> 0.25%, not dead',
                            sourceMaps: !isProduction,
                            comments: !isProduction,
                            presets: [require.resolve('@wordpress/babel-preset-default')],
                            plugins: ['@babel/plugin-syntax-jsx', '@babel/plugin-transform-runtime'],
                        },
                    },
                ],
            },
        ],
    },
    plugins: [
        new webpack.ProvidePlugin({
            $: 'jquery',
            jQuery: 'jquery',
            'window.jQuery': 'jquery',
            _: 'lodash',
            bootstrap: 'bootstrap',
            Popper: '@popperjs',
            select2: 'select2',
            bs: 'bootstrap',
        }),

        new DependencyExtractionWebpackPlugin({
            injectPolyfill: true,
            combineAssets: false,
        }),
    ],
};

webpackConfig = mergeWithRules({
    module: {
        rules: {
            test: 'match',
            use: {
                loader: 'match',
                options: 'replace',
            },
        },
    },
})(baseConfig, webpackConfig);

// ========================== Add Starting Plugins ========================== //

const esLint = _.findIndex(startingPlugins, function (o) {
    return o.constructor.name === 'ESLintWebpackPlugin';
});

startingPlugins[esLint] = new ESLintPlugin({
    failOnWarning: false,
    emitError: !isProduction,
    emitWarning: !isProduction,
    formatter: require('eslint-formatter-pretty'),
    fix: true,
    overrideConfigFile: path.join(filePaths.blocks.src, '.eslintrc.js'),
});

webpackConfig = mergeWithCustomize({
    customizeArray: customizeArray({
        plugins: 'prepend',
    }),
})(webpackConfig, {
    plugins: startingPlugins,
});

// =========================== Add Ending Plugins =========================== //

webpackConfig = mergeWithCustomize({
    customizeArray: unique('plugins', ['ESLintPlugin'], (plugin) => plugin.constructor && plugin.constructor.name),
})(webpackConfig, {
    plugins: endingPlugins,
});

if (_.has(webpackConfig, 'name')) {
    webpackConfig = [webpackConfig];
}

_.unset(webpackConfig, 'target');

const terser = _.findIndex(webpackConfig.optimization.minimizer, function (o) {
    return o.constructor.name === 'TerserPlugin';
});

webpackConfig.optimization.minimizer[terser] = new TerserPlugin({
    test: /\.js(\?.*)?$/i,
    terserOptions: {
        format: {
            comments: /translators:/i,
            ecma: 2017,
            beautify: !isProduction,
        },
        ecma: 2017,
        safari10: true,
        mangle: isProduction
            ? {
                  reserved: ['__', '_n', '_nx', '_x'],
              }
            : false,
        compress: isProduction
            ? {
                  passes: 2,
              }
            : false,
        sourceMap: !isProduction,
    },
    parallel: true,
    extractComments: false,
});

if (!buildWatch && (config.enabled.debug || argv.stats === 'verbose')) {
    debug(webpackConfig);
}

module.exports = webpackConfig;
