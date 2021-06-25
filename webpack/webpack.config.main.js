/** ============================================================================
 * webpack.config.main
 *
 * @package   RWP
 * @since     0.1.0
 * @version   0.1.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2021 RIESTER
 * ========================================================================== */

const path = require('path');
const {
	mergeWithCustomize,
	customizeArray,
	customizeObject,
	unique,
	merge,
	mergeWithRules,
} = require('webpack-merge');
const webpack = require('webpack');

const {
	startingPlugins,
	baseConfig,
	endingPlugins,
} = require('./webpack.config');

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
module.exports = webpackConfig;
