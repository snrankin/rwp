/** ============================================================================
 * webpack.config.main
 *
 * @since     0.1.0
 * @version   0.1.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2021 RIESTER
 * ========================================================================== */

const { mergeWithCustomize, customizeArray, merge } = require('webpack-merge');
const webpack = require('webpack');
const _ = require('lodash');
const FriendlyErrorsWebpackPlugin = require('@xpamamadeus/friendly-errors-webpack-plugin');
const { startingPlugins, baseConfig } = require('./webpack.config');

const { rwpDebug } = require('./utils');

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
		new FriendlyErrorsWebpackPlugin(),
	],
};

webpackConfig = merge(baseConfig, webpackConfig);

webpackConfig = mergeWithCustomize({
	customizeArray: customizeArray({
		plugins: 'prepend',
	}),
})(webpackConfig, { plugins: startingPlugins });

if (_.has(webpackConfig, 'name')) {
	webpackConfig = [webpackConfig];
}

rwpDebug(webpackConfig);

module.exports = webpackConfig;
