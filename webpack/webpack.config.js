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
const _ = require('lodash');
const { merge, mergeWithCustomize, customizeArray } = require('webpack-merge');
const StyleLintPlugin = require('stylelint-webpack-plugin');
const magicImporter = require('node-sass-magic-importer');
const ESLintPlugin = require('eslint-webpack-plugin');
const RemoveEmptyScriptsPlugin = require('webpack-remove-empty-scripts');
const ExtractCssChunks = require('mini-css-extract-plugin');
const RemovePlugin = require('remove-files-webpack-plugin');
const { createConfig } = require('./config');
const { argv } = require('yargs');
const groupName = !_.isNil(argv.name) ? argv.name : '';
const buildWatch = !_.isNil(argv.watch) ? true : false;
const configName = !_.isNil(argv['config-name']) ? argv['config-name'] : '';
const config = createConfig(groupName, configName);
const fs = require('fs');
const { extendDefaultPlugins } = require('svgo');

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
];

exports.cssLoaders = cssLoaders;

const startingPlugins = config.enabled.cachebusting
	? [new RemovePlugin(config.clean)]
	: [];

exports.startingPlugins = startingPlugins;

const assetname = config.enabled.cachebusting
	? `${config.cachebusting}`
	: '[name]';

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
								importer: magicImporter(),
							},
						},
					},
				],
			},
			{
				test: /\.(ttf|otf|eot|woff2?|png|jpe?g|gif|svg|ico)$/,
				use: [
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
		Fancybox: 'Fancybox',
		select2: 'select2',
		lodash: {
			commonjs: 'lodash',
			commonjs2: 'lodash',
			amd: 'lodash',
			root: '_',
		},
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

if (config.enabled.manifest && !buildWatch) {
	const { WebpackManifestPlugin } = require('webpack-manifest-plugin');
	const manifestPath = path.join(config.paths.dist, 'manifest.json');
	let manifestSeed = {};
	if (fs.existsSync(manifestPath)) {
		const rawdata = fs.readFileSync(manifestPath);
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

					const notAllowedDirs = _.compact(
						_.uniq(_.union(distDirs, srcDirs, publicDirs))
					);
					const filename = path.basename(file.path);
					let fileDir = path.dirname(file.path).split(path.sep);
					fileDir = fileDir.filter((item) => {
						return item !== '' && !notAllowedDirs.includes(item);
					}, fileDir);
					if (file.isChunk) {
						let chunkPath = fileDir.join('/');
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
													//eslint-disable-next-line
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
