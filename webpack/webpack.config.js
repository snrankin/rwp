/**
 * ============================================================================
 * webpack.config
 *
 * @since     0.1.0
 * @version   1.0.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2021 RIESTER
 * ==========================================================================
 */

const path = require('path');
const fs = require('fs');
const _ = require('lodash');
const { argv } = require('yargs');
const { merge, mergeWithCustomize, customizeArray } = require('webpack-merge');
const StyleLintPlugin = require('stylelint-webpack-plugin');
const ESLintPlugin = require('eslint-webpack-plugin');
const RemoveEmptyScriptsPlugin = require('webpack-remove-empty-scripts');
const ExtractCssChunks = require('mini-css-extract-plugin');
const magicImporter = require('node-sass-magic-importer');
const RemovePlugin = require('remove-files-webpack-plugin');
const FriendlyErrorsWebpackPlugin = require('@xpamamadeus/friendly-errors-webpack-plugin');
const { WebpackManifestPlugin } = require('webpack-manifest-plugin');

const { createConfig } = require('./config');

const isProduction = !_.isNil(argv.p) ? true : false;
const groupName = !_.isNil(argv.name) ? argv.name : '';
const buildWatch = !_.isNil(argv.watch) ? true : false;
const configName = !_.isNil(argv['config-name']) ? argv['config-name'] : '';
const config = createConfig(groupName, configName);
exports.config = config;

const manifestPath = path.join(config.paths.dist, 'manifest.json');
const manifestSeed = fs.existsSync(manifestPath) ? JSON.parse(fs.readFileSync(manifestPath)) : {};

const cssLoaders = [
	{
		loader: ExtractCssChunks.loader,
		options: {
			publicPath: config.paths.public,
		},
	},
	{
		loader: 'css-loader',
		options: {
			sourceMap: !isProduction,
		},
	},
	{
		loader: 'postcss-loader',
		options: {
			sourceMap: !isProduction,
			postcssOptions: {
				plugins: [
					'postcss-fixes',
					[
						'postcss-inline-svg',
						{
							paths: [path.resolve(config.paths.src, config.folders.images), path.resolve(config.paths.root, 'node_modules/bootstrap-icons/icons')],
						},
					],
					'postcss-sort-media-queries',
					'autoprefixer',
					isProduction
						? [
								'cssnano',
								{
									preset: [
										'default',
										{
											discardComments: {
												removeAll: true,
											},
										},
									],
								},
						  ]
						: '',
				],
			},
		},
	},
];

exports.cssLoaders = cssLoaders;

const startingPlugins = config.enabled.cachebusting ? [new RemovePlugin(config.clean)] : [];

exports.startingPlugins = startingPlugins;

const endingPlugins = [
	new WebpackManifestPlugin({
		basePath: '',
		publicPath: '',
		map: (file) => {
			let fileName = !_.isNil(file.name) ? file.name : file.path;
			fileName = path.basename(fileName.replace(/\?.*/gm, ''));
			file.name = fileName;
			return file;
		},
		seed: manifestSeed,
		removeKeyHash: true,
		writeToFileEmit: true,
	}),
	new FriendlyErrorsWebpackPlugin({
		logLevel: buildWatch ? 'SILENT' : 'WARNING',
		clearConsole: true,
	}),
];

exports.endingPlugins = endingPlugins;

let webpackConfig = {
	module: {
		rules: [
			{
				test: /\.(sc|sa|j|cs)s$/,
				enforce: 'pre',
				use: ['source-map-loader'],
			},
			{
				test: /\.css$/,
				use: cssLoaders,
			},
			{
				test: /\.(sc|sa)ss$/,
				use: [
					...cssLoaders,
					{
						loader: 'sass-loader',
						options: {
							sassOptions: {
								sourceMap: config.enabled.sourcemaps,
								indentWidth: 4,
								fiber: false,
								importer: magicImporter(),
							},
						},
					},
				],
			},
			{
				test: /\.(woff|woff2|eot|ttf|otf)$/i,
				type: 'asset',
				generator: {
					filename: `${config.folders.fonts}/${config.assetname}`,
				},
			},
			{
				test: /\.(png|svg|jpg|jpeg|gif|ico)$/i,
				type: 'asset',
				generator: {
					filename: `${config.folders.images}/${config.assetname}`,
				},
			},
		],
	},
	resolve: {
		modules: ['node_modules'],
		enforceExtension: false,
	},
	externals: {
		jquery: 'jQuery',
		lodash: {
			commonjs: 'lodash',
			commonjs2: 'lodash',
			amd: 'lodash',
			root: '_',
		},
	},
	plugins: [
		new ESLintPlugin({
			failOnWarning: !buildWatch,
			emitError: !isProduction,
			emitWarning: !isProduction,
			fix: true,
		}),
		new StyleLintPlugin({
			failOnError: !buildWatch,
			emitError: !isProduction,
			emitWarning: !isProduction,
			fix: true,
		}),
		new RemoveEmptyScriptsPlugin(),
		new ExtractCssChunks({
			filename: `${config.folders.css}/${config.filename}.css`,
		}),
	],
};
webpackConfig = merge(config.webpack, webpackConfig);

if ('app' === configName) {
	webpackConfig.output.library = {
		name: 'rwp',
		type: 'umd',
	};
}

if (isProduction) {
	const ImageMinimizerPlugin = require('image-minimizer-webpack-plugin');
	webpackConfig = mergeWithCustomize({
		customizeArray: customizeArray({
			plugins: 'append',
		}),
	})(webpackConfig, {
		plugins: [
			new ImageMinimizerPlugin({
				minimizerOptions: {
					plugins: ['gifsicle', 'jpegtran', 'optipng', 'svgo'],
				},
				loader: false,
			}),
		],
	});
}

exports.baseConfig = webpackConfig;
