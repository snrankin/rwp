/** ============================================================================
 * webpack.config
 *
 * @package   RWP
 * @since     0.1.0
 * @version   0.1.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2021 RIESTER
 * ========================================================================== */

const path = require('path');
const _ = require('lodash');
const { merge, mergeWithCustomize, customizeArray } = require('webpack-merge');
const StyleLintPlugin = require('stylelint-webpack-plugin');
const FriendlyErrorsWebpackPlugin = require('friendly-errors-webpack-plugin');
const WebpackBuildNotifierPlugin = require('webpack-build-notifier');
const magicImporter = require('node-sass-magic-importer');
const ESLintPlugin = require('eslint-webpack-plugin');
const WebpackBar = require('webpackbar');
const FixStyleOnlyEntriesPlugin = require('webpack-fix-style-only-entries');
const ExtractCssChunks = require('extract-css-chunks-webpack-plugin');
const RemovePlugin = require('remove-files-webpack-plugin');
// const stylelintFormatter = require('stylelint-formatter-pretty');
const { createConfig } = require('./config');
const pkg = require('../package.json');
const { argv } = require('yargs');
let name = argv.name || '';
let configName = argv.configName || '';
const config = createConfig(configName, name);
const fs = require('fs');
const { extendDefaultPlugins } = require('svgo');
const cssLoaders = [
	...config.cacheloader,
	{
		loader: ExtractCssChunks.loader,
		options: {
			publicPath: config.paths.public,
		},
	},
	{
		loader: 'css-loader',
		options: {
			sourceMap: config.enabled.sourcemaps,
		},
	},
	{
		loader: 'postcss-loader',
		options: {
			sourceMap: config.enabled.sourcemaps,
			postcssOptions: {
				plugins: [
					'postcss-fixes',
					[
						'postcss-inline-svg',
						{
							paths: [
								path.resolve(
									config.paths.src,
									config.folders.images
								),
								path.resolve(
									config.paths.root,
									'node_modules/bootstrap-icons/icons'
								),
							],
						},
					],
					'postcss-sort-media-queries',
					'autoprefixer',
					config.enabled.optimize
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
	{
		loader: 'resolve-url-loader',
		options: {
			sourceMap: config.enabled.sourcemaps,
			debug: true,
		},
	},
];

exports.cssLoaders = cssLoaders;

const startingPlugins = [
	new WebpackBar({
		name: name !== '' ? name : pkg.displayName,
		fancy: config.env.development,
		reporters: ['fancy'],
	}),
	new RemovePlugin(config.clean),
];

exports.startingPlugins = startingPlugins;

const endingPlugins = [
	new FriendlyErrorsWebpackPlugin(),
	new WebpackBuildNotifierPlugin(config.notify),
];

exports.endingPlugins = endingPlugins;

let assetname = config.enabled.cachebusting
	? `${config.cachebusting}`
	: '[name]';

let webpackConfig = {
	module: {
		rules: [
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
								importer: magicImporter(),
							},
						},
					},
				],
			},
			{
				test: /\.(ttf|otf|eot|woff2?|png|jpe?g|gif|svg|ico)$/,
				use: [
					...config.cacheloader,
					{
						loader: 'file-loader',
						options: {
							name: `${assetname}.[ext]`,
							outputPath: (url) => {
								const distPath = config.paths.dist;
								const fileType = path.extname(url);
								const isFont = new RegExp(
									/\.(ttf|otf|eot|woff2?)$/
								).test(fileType);
								let newPath;
								if (isFont) {
									newPath = path.join(
										distPath,
										config.folders.fonts,
										url
									);
								} else {
									newPath = path.join(
										distPath,
										config.folders.images,
										url
									);
								}

								const relPath = path.relative(
									distPath,
									newPath
								);

								return relPath;
							},

							publicPath: (url) => {
								const distPath = config.paths.public;
								const fileType = path.extname(url);
								const isFont = new RegExp(
									/\.(ttf|otf|eot|woff2?)$/
								).test(fileType);
								let newPath;
								if (isFont) {
									newPath = path.join(
										distPath,
										config.folders.fonts,
										url
									);
								} else {
									newPath = path.join(
										distPath,
										config.folders.images,
										url
									);
								}

								return newPath;
							},
						},
					},
				],
			},
		],
	},
	resolve: {
		modules: ['node_modules'],
		enforceExtension: false,
	},
	externals: {
		jquery: 'jQuery',
		'tiny-slider': 'tns',
		fancybox: 'fancybox',
		select2: 'select2',
	},
	plugins: [
		new ESLintPlugin({
			failOnWarning: !config.enabled.watcher,
			emitError: config.env.development,
			emitWarning: config.env.development,
			fix: true,
		}),
		new StyleLintPlugin({
			failOnError: !config.enabled.watcher,
			emitError: config.env.development,
			emitWarning: config.env.development,
			fix: true,
			// formatter: stylelintFormatter,
		}),
		new FixStyleOnlyEntriesPlugin(),
		new ExtractCssChunks({
			filename: `${config.folders.css}/${config.filename}.css`,
		}),
	],
};
webpackConfig = merge(config.webpack, webpackConfig);

if (config.enabled.manifest) {
	const { WebpackManifestPlugin } = require('webpack-manifest-plugin');
	let manifestPath = path.join(config.paths.dist, 'manifest.json');
	let manifestSeed = {};
	if (fs.existsSync(manifestPath)) {
		let rawdata = fs.readFileSync(manifestPath);
		manifestSeed = JSON.parse(rawdata);
	}
	webpackConfig = mergeWithCustomize({
		customizeArray: customizeArray({
			plugins: 'append',
		}),
	})(webpackConfig, {
		plugins: [
			new WebpackManifestPlugin({
				basePath: '',
				map: (file) => {
					let distDirs = config.paths.dist;
					distDirs = distDirs.split(path.sep);
					let srcDirs = config.paths.src;
					srcDirs = srcDirs.split(path.sep);
					let publicDirs = config.paths.public;
					publicDirs = publicDirs.split(path.sep);

					let notAllowedDirs = _.compact(
						_.uniq(_.union(distDirs, srcDirs, publicDirs))
					);
					var filename = path.basename(file.path);
					var fileDir = path.dirname(file.path).split(path.sep);
					fileDir = fileDir.filter((item) => {
						return item !== '' && !notAllowedDirs.includes(item);
					}, fileDir);
					if (file.isChunk) {
						var chunkPath = fileDir.join('/');
						chunkPath = path.join(
							chunkPath,
							config.prefix + file.name
						);
						file.name = chunkPath;
					}
					fileDir.push(filename);
					fileDir = fileDir.join('/');
					file.path = fileDir;
					return file;
				},
				seed: manifestSeed,
				removeKeyHash: true,
				writeToFileEmit: true,
			}),
		],
	});
}

if (config.enabled.optimize) {
	const ImageMinimizerPlugin = require('image-minimizer-webpack-plugin');
	webpackConfig = mergeWithCustomize({
		customizeArray: customizeArray({
			plugins: 'prepend',
		}),
	})(webpackConfig, {
		plugins: [
			new ImageMinimizerPlugin({
				minimizerOptions: {
					// Lossless optimization with custom option
					// Feel free to experiment with options for better result for you
					plugins: [
						['gifsicle', { interlaced: true }],
						['jpegtran', { progressive: true }],
						['optipng', { optimizationLevel: 5 }],
						// Svgo configuration here https://github.com/svg/svgo#configuration
						[
							'svgo',
							{
								plugins: extendDefaultPlugins([
									{
										name: 'removeViewBox',
										active: false,
									},
									{
										name: 'addAttributesToSVGElement',
										params: {
											attributes: [
												{
													xmlns:
														'http://www.w3.org/2000/svg',
												},
											],
										},
									},
								]),
							},
						],
					],
				},
			}),
		],
	});
}

exports.baseConfig = webpackConfig;
