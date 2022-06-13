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
const { mergeWithCustomize, customizeArray, merge, mergeWithRules, unique } = require('webpack-merge');
const DependencyExtractionWebpackPlugin = require('@wordpress/dependency-extraction-webpack-plugin');
const webpack = require('webpack');
let wordPressConfig = require('@wordpress/scripts/config/webpack.config');
const ESLintPlugin = require('eslint-webpack-plugin');
const TerserPlugin = require('terser-webpack-plugin');
// ======================== Import Local Dependencies ======================= //

const { isEmpty, debug, env, filePaths } = require('./utils/utils');
let { startingPlugins, config, baseConfig, endingPlugins } = require('./utils/config');
const isProduction = env() === 'production' ? true : false;
// =========================== Setup File Globals =========================== //

const buildWatch = !isEmpty(argv.watch) ? true : false;

// ============= Filter out unwanted items from Wordpress Config ============ //

wordPressConfig = _.pick(wordPressConfig, ['resolve', 'plugins']);

wordPressConfig.plugins = wordPressConfig.plugins.filter((plugin) => {
	if (plugin.constructor.name !== 'CleanWebpackPlugin' && plugin.constructor.name !== 'Plugin' && plugin.constructor.name !== 'FixStyleWebpackPlugin' && plugin.constructor.name !== 'MiniCssExtractPlugin' && plugin.constructor.name !== 'DependencyExtractionWebpackPlugin') {
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
	module: {
		rules: [
			{
				test: /\.(j|t)sx?$/,
				exclude: [/node_modules/, /vendor/],
				use: [
					{
						loader: 'babel-loader',
						options: {
							babelrc: false,
							configFile: false,
							presets: [require.resolve('@wordpress/babel-preset-default')],
							plugins: ['@babel/plugin-syntax-jsx', '@babel/plugin-transform-runtime'],
						},
					},
				],
			},
		],
	},
	optimization: {
		minimize: true,
		minimizer: [
			new TerserPlugin({
				test: /\.js(\?.*)?$/i,
				terserOptions: {
					format: {
						comments: false,
						ecma: 2017,
						beautify: isProduction ? false : true,
					},
					ecma: 2017,
					safari10: true,
					mangle: isProduction ? true : false,
					compress: isProduction ? true : false,
				},

				extractComments: false,
			}),
		],
		providedExports: true,
		splitChunks: {
			maxInitialRequests: Infinity,
			minSize: 0,
			hidePathInfo: true,
			chunks: 'all',
			cacheGroups: {
				defaultVendors: false,
				default: false,
				vendors: {
					test: /[\\/]node_modules[\\/]/,
					layer: 'vendors',
					chunks: 'all',
					idHint: 'vendors',
					name: 'vendors',
					priority: -5,
				},
			},
		},
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

let esLint = _.findIndex(startingPlugins, function (o) {
	return o.constructor.name == 'ESLintWebpackPlugin';
});

startingPlugins[esLint] = new ESLintPlugin({
	failOnWarning: false,
	emitError: !isProduction,
	emitWarning: !isProduction,
	formatter: require('eslint-formatter-pretty'),
	fix: true,
	overrideConfigFile: path.join(filePaths.blocksSrc, '.eslintrc.js'),
});

webpackConfig = mergeWithCustomize({
	customizeArray: customizeArray({
		plugins: 'prepend',
	}),
})(webpackConfig, { plugins: startingPlugins });

// =========================== Add Ending Plugins =========================== //

webpackConfig = mergeWithCustomize({
	customizeArray: unique('plugins', ['ESLintPlugin'], (plugin) => plugin.constructor && plugin.constructor.name),
})(webpackConfig, { plugins: endingPlugins });

if (_.has(webpackConfig, 'name')) {
	webpackConfig = [webpackConfig];
}

_.unset(webpackConfig, 'target');

if (!buildWatch && (config.enabled.debug || argv.stats === 'verbose')) {
	debug(webpackConfig);
}

module.exports = webpackConfig;
