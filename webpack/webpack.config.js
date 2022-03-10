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
const { mergeWithCustomize, customizeArray, merge } = require('webpack-merge');

// ======================== Import Local Dependencies ======================= //

const { isEmpty, debug } = require('./utils/utils');
const { startingPlugins, config, baseConfig, endingPlugins } = require('./utils/config');

// =========================== Setup File Globals =========================== //

const buildWatch = !isEmpty(argv.watch) ? true : false;

// ========================== Start Webpack Config ========================== //

let webpackConfig = {}; // Add custom options to webpack here

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

if (!buildWatch && config.enabled.debug) {
	debug(webpackConfig);
}

module.exports = webpackConfig;
