/** ============================================================================
 * webpack.config.blocks
 *
 * @package   RWP
 * @since     0.1.0
 * @version   0.1.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2021 RIESTER
 * ========================================================================== */

const assert = require('assert');
const {
	mergeWithCustomize,
	customizeArray,
	customizeObject,
	unique,
	merge,
	mergeWithRules,
} = require('webpack-merge');

const DependencyExtractionWebpackPlugin = require('@wordpress/dependency-extraction-webpack-plugin');
const FriendlyErrorsWebpackPlugin = require('friendly-errors-webpack-plugin');
const MiniCSSExtractPlugin = require('mini-css-extract-plugin');
const wordPressConfig = require('@wordpress/scripts/config/webpack.config');

const { createConfig } = require('./config');
const {
	startingPlugins,
	baseConfig,
	endingPlugins,
} = require('./webpack.config');

let webpackConfig = {
	...wordPressConfig,
	plugins: [
		new DependencyExtractionWebpackPlugin({
			injectPolyfill: true,
			combineAssets: false,
		}),
	],
};

webpackConfig = merge(baseConfig, webpackConfig);

webpackConfig.output = merge(webpackConfig.output, baseConfig.output);

let modules1 = {
	module: baseConfig.module,
};

let wordPressConfigRules = wordPressConfig.module.rules.filter((rule) => {
	if (
		rule.test.constructor == RegExp &&
		rule.test.source !== '\\.css$' &&
		rule.test.source !== '\\.(sc|sa)ss$'
	) {
		return rule;
	}
});

let modules2 = {
	module: {
		rules: wordPressConfigRules,
	},
};

let modules = mergeWithRules({
	module: {
		rules: {
			test: 'match',
			use: {
				loader: 'match',
				options: 'replace',
			},
		},
	},
})(modules2, modules1);

modules = modules.module;

// //webpackConfig = merge(baseConfig, wordPressConfig, webpackConfig);

webpackConfig.plugins = webpackConfig.plugins.filter((plugin) => {
	if (
		plugin.constructor.name !== 'CleanWebpackPlugin' &&
		plugin.constructor.name !== 'Plugin' &&
		plugin.constructor.name !== 'MiniCssExtractPlugin' &&
		plugin.constructor.name !== 'FixStyleWebpackPlugin'
	) {
		return plugin;
	}
});

webpackConfig.module = modules;
webpackConfig.output = baseConfig.output;
webpackConfig.entry = baseConfig.entry;

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
