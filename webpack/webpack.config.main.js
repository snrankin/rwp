/**
 * ============================================================================
 * webpack.config.main
 *
 * @since     0.1.0
 * @version   0.1.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2021 RIESTER
 * ==========================================================================
 */

const { mergeWithCustomize, customizeArray, merge } = require('webpack-merge');
const webpack = require('webpack');
const _ = require('lodash');
const CopyPlugin = require('copy-webpack-plugin');
const { startingPlugins, config, baseConfig, endingPlugins } = require('./webpack.config');
// const { rwpDebug } = require('./utils');
let webpackConfig = {
	module: {
		rules: [
			{
				enforce: 'pre',
				test: /\.js$/,
				loader: 'import-glob-loader',
			},
			{
				test: /\.js$/,
				exclude: [/node_modules/, /vendor/],
				use: [
					{
						loader: 'babel-loader',
						options: {
							presets: [
								[
									'@babel/preset-env',
									{
										useBuiltIns: 'entry',
										corejs: { version: 3, proposals: true },
									},
								],
							],
							plugins: ['@babel/plugin-transform-runtime'],
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
		}),
	],
};

if (!_.isNil(config.copy)) {
	webpackConfig = mergeWithCustomize({
		customizeArray: customizeArray({
			plugins: 'append',
		}),
	})(webpackConfig, {
		plugins: [
			new CopyPlugin({
				patterns: config.copy,
				options: {
					concurrency: 100,
				},
			}),
		],
	});
}

webpackConfig = merge(baseConfig, webpackConfig);

webpackConfig = mergeWithCustomize({
	customizeArray: customizeArray({
		plugins: 'prepend',
	}),
})(webpackConfig, { plugins: startingPlugins });

webpackConfig = mergeWithCustomize({
	customizeArray: customizeArray({
		plugins: 'append',
	}),
})(webpackConfig, { plugins: endingPlugins });

if (_.has(webpackConfig, 'name')) {
	webpackConfig = [webpackConfig];
}

// rwpDebug(webpackConfig);

module.exports = webpackConfig;
