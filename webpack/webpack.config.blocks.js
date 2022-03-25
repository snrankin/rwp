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
const { argv } = require('yargs');
const { mergeWithCustomize, customizeArray, merge, mergeWithRules } = require('webpack-merge');
const DependencyExtractionWebpackPlugin = require('@wordpress/dependency-extraction-webpack-plugin');
const wordPressConfig = require('@wordpress/scripts/config/webpack.config');

// ======================== Import Local Dependencies ======================= //

const { isEmpty, debug } = require('./utils/utils');
let { startingPlugins, config, baseConfig, endingPlugins } = require('./utils/config');

// =========================== Setup File Globals =========================== //

const buildWatch = !isEmpty(argv.watch) ? true : false;

// ============= Filter out unwanted items from Wordpress Config ============ //

wordPressConfig.module.rules = wordPressConfig.module.rules.filter((rule) => {
	if (rule.test.constructor == RegExp && rule.test.source !== '\\.css$' && rule.test.source !== '\\.(sc|sa)ss$') {
		return rule;
	}
	return false;
});

wordPressConfig.plugins = wordPressConfig.plugins.filter((plugin) => {
	if (plugin.constructor.name !== 'CleanWebpackPlugin' && plugin.constructor.name !== 'Plugin' && plugin.constructor.name !== 'FixStyleWebpackPlugin') {
		return plugin;
	}
	return false;
});

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
	plugins: [
		new DependencyExtractionWebpackPlugin({
			injectPolyfill: true,
			combineAssets: false,
		}),
	],
};

webpackConfig = merge(baseConfig, webpackConfig);

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
