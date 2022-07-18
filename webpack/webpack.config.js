/** ============================================================================
 * webpack.config
 *
 * @since     0.1.0
 * @version   1.0.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2021 RIESTER
 * ========================================================================== */

// ======================= Import Vendor Dependencies ======================= //

const _ = require('lodash');
const { argv } = require('yargs');
const path = require('path');
const webpack = require('webpack');
const { mergeWithCustomize, customizeArray, mergeWithRules } = require('webpack-merge');

const LodashModuleReplacementPlugin = require('lodash-webpack-plugin');

// ======================== Import Local Dependencies ======================= //

const { debug, filePaths, env } = require('./utils/utils');
const { startingPlugins, isProduction, baseConfig, endingPlugins, buildWatch, config } = require('./utils/config');

// =========================== Setup File Globals =========================== //

// ========================== Start Webpack Config ========================== //

let webpackConfig = {
    module: {
        rules: [
            {
                test: /\.modernizrrc$/,
                use: ['@sect/modernizr-loader'],
            },
            {
                test: /\.(j|t)sx$/,
                exclude: [/node_modules/, /vendors/, /modernizr\.js$/],
                use: [
                    {
                        loader: 'babel-loader',
                        options: {
                            envName: env(),
                            targets: '> 0.25%, not dead',
                            sourceMaps: !isProduction,
                            comments: !isProduction,
                            presets: [
                                [
                                    '@babel/preset-env',
                                    {
                                        useBuiltIns: 'entry',
                                        corejs: { version: 3, proposals: true },
                                    },
                                ],
                            ],
                            plugins: ['lodash', '@babel/plugin-transform-runtime'],
                        },
                    },
                ],
            },
        ],
    },
    resolve: {
        extensions: ['.ts', '.js'],
        alias: {
            modernizr$: path.resolve(filePaths.root, '.modernizrrc'),
        },
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
        new LodashModuleReplacementPlugin(),
    ],
}; // Add custom options to webpack here

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

webpackConfig = mergeWithCustomize({
    customizeArray: customizeArray({
        plugins: 'prepend',
    }),
})(webpackConfig, { plugins: startingPlugins });

// =========================== Add Ending Plugins =========================== //

webpackConfig = mergeWithCustomize({
    customizeArray: customizeArray({
        plugins: 'append',
    }),
})(webpackConfig, { plugins: endingPlugins });

if (_.has(webpackConfig, 'name')) {
    webpackConfig = [webpackConfig];
}

if (!buildWatch && (config.enabled.debug || argv.stats === 'verbose')) {
    debug(webpackConfig);
}

module.exports = webpackConfig;
