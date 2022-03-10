/** ============================================================================
 * config
 *
 * @version   1.0.0
 * @author    Sam Rankin <srankin@riester.com>
 * @copyright 2022 RIESTER
 * ========================================================================== */

// ======================= Import Vendor Dependencies ======================= //
const _ = require('lodash');
const path = require('path');
const webpack = require('webpack');
const { argv } = require('yargs');
const { merge } = require('webpack-merge');
const StyleLintPlugin = require('stylelint-webpack-plugin');
const ESLintPlugin = require('eslint-webpack-plugin');
const RemoveEmptyScriptsPlugin = require('webpack-remove-empty-scripts');
const ExtractCssChunks = require('mini-css-extract-plugin');
const CleanupMiniCssExtractPlugin = require('cleanup-mini-css-extract-plugin');
const magicImporter = require('node-sass-magic-importer');
const FriendlyErrorsWebpackPlugin = require('@soda/friendly-errors-webpack-plugin');
const WebpackBuildNotifierPlugin = require('webpack-build-notifier');
const { WebpackManifestPlugin } = require('webpack-manifest-plugin');

// ======================== Import Local Dependencies ======================= //
const { isEmpty, env, manifest, filePaths, fileNames } = require('./utils');

const configFile = require('../../config.json');

// =========================== Setup File Globals =========================== //

const folders = _.get(configFile, 'folders', {});
exports.folders = folders;

const groupName = !isEmpty(argv.name) ? argv.name : '';
const buildWatch = !isEmpty(argv.watch) ? true : false;
const configName = !isEmpty(argv['config-name']) ? argv['config-name'] : '';
const isProduction = env === 'production' ? true : false;
const rootPath = filePaths && filePaths.root ? filePaths.root : process.cwd();

const buildStats = !isEmpty(argv.stats)
	? argv.stats
	: {
			// preset: 'minimal',
			// cachedAssets: false,
			// cachedModules: false,
			// children: false,
			// chunks: false,
			colors: true,
			// context: filePaths.src,
			// depth: false,
			// entrypoints: 'auto',
			// env: true,
			// errorDetails: 'auto',
			// errorStack: false,
			// errors: false,
			excludeAssets: ['**/*.map'],
			// groupAssetsByChunk: true,
			// hash: false,
			logging: false,
			// moduleAssets: true,
			modules: false,
			nestedModules: false,
			// publicPath: false,
			reasons: false,
			source: true,
			// timings: false,
			// version: false,
			// warnings: false,
	  };

function createConfig(groupName = '', configName = '') {
	const entryFiles = fileNames(groupName, configName, configFile.entry);

	let customConfig = {};
	if (_.isString(groupName) && groupName !== '' && _.has(configFile.entry, groupName)) {
		customConfig = configFile.entry[groupName];
		customConfig = _.omit(customConfig, 'files');
	}
	_.defaultsDeep(customConfig, configFile);
	const fileprefix = !_.isUndefined(customConfig.fileprefix) ? customConfig.fileprefix : '';
	customConfig.paths = filePaths;

	let filenameTemplate = customConfig.enabled.cachebusting ? `${fileprefix}${customConfig.cachebusting}` : `${fileprefix}[name]`;

	if (isProduction) {
		filenameTemplate = filenameTemplate + '.min';
	}

	const assetnameTemplate = customConfig.enabled.cachebusting ? `${customConfig.cachebusting}[ext][query]` : '[name][ext][query]';

	let newConfig = {
		webpack: {
			mode: isProduction ? 'production' : 'development',
			entry: entryFiles,
			context: filePaths.src || rootPath,
			output: {
				path: filePaths.dist,
				publicPath: !isEmpty(filePaths.public) ? filePaths.public : 'auto',
				filename: path.join(folders.js, `${filenameTemplate}.js`),
				assetModuleFilename: assetnameTemplate,
				// clean: {
				// 	keep: /\.(json|html)$/,
				// },
				library: 'rwp',
				chunkFilename: '[name].js',
			},
			stats: buildStats,
			watchOptions: {
				ignored: [filePaths.dist, path.join(rootPath, 'node_modules')],
			},
			optimization: {
				providedExports: true,
				minimize: isProduction ? true : false,
				nodeEnv: isProduction ? 'production' : 'development',
				splitChunks: {
					hidePathInfo: true,
					cacheGroups: {
						vendors: {
							test: /^[\\/]node_modules[\\/](?!(?:bootstrap|@fortawesome|bootstrap-icons)[\\/]).*/,
							layer: 'vendors',
							chunks: 'all',
							idHint: 'vendors',
							filename: path.join(folders.js, `${filenameTemplate}.js`),
							name: false,
						},
					},
				},
			},
			node: {
				__filename: true,
				__dirname: true,
			},
			infrastructureLogging: {
				level: 'warn',
			},
			ignoreWarnings: [
				{
					module: /sass-loader\/dist\/cjs\.js/, // A RegExp
				},
			],
		},
		filename: filenameTemplate,
		assetname: assetnameTemplate,
		prefix: fileprefix,
		notify: {
			appName: configFile.app.name,
			buildSuccessful: true,
			suppressSuccess: 'initial',
			logo: filePaths.favicon,
			activateTerminalOnError: true,
			messageFormatter: (error) => {
				let type = _.get(error, 'error.name', '');
				let message = _.get(error, 'error.message', '');

				if ('SassError' === type) {
					let file = _.get(error, 'error.originalSassError.file', '');
					let line = _.get(error, 'error.originalSassError.line', '');
					file = path.relative(process.cwd(), file);
					message = `Error in ${file}:${line}`;
				}
				return message;
			},
			onClick: (notifier, options) => {
				let file = _.get(options, 'message', '');
				file = file.replace(/^Error\sin\s/, '');
				file = path.join(process.cwd(), file);
				file = `code -g ${file}`;

				const child_process = require('child_process');
				child_process.exec(file);
			},
		},
	};

	if (!isProduction) {
		newConfig.webpack.devtool = 'source-map';
	}

	newConfig = _.defaultsDeep(newConfig, customConfig);

	if (!isEmpty(configName) && _.isString(configName) && configName !== '') {
		newConfig = _.merge({ webpack: { name: configName } }, newConfig);
	}

	return newConfig;
}

const config = createConfig(groupName, configName);

exports.config = config;

const cssLoaders = [
	{
		loader: ExtractCssChunks.loader,
		options: {
			publicPath: filePaths.public,
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
					'postcss-momentum-scrolling',
					'autoprefixer',
					[
						'postcss-inline-svg',
						{
							paths: [filePaths.imagesSrc, path.join(filePaths.node, 'bootstrap-icons', 'icons')],
						},
					],
					[
						'postcss-sort-media-queries',
						{
							configuration: {
								unitlessMqAlwaysFirst: true,
							},
						},
					],
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
						: [
								'cssnano',
								{
									preset: 'lite',
								},
						  ],
				],
			},
		},
	},
];

exports.cssLoaders = cssLoaders;

const jsLoaders = [
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
];

exports.jsLoaders = jsLoaders;

let webpackConfig = {
	module: {
		rules: [
			...jsLoaders,
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
						loader: 'resolve-url-loader',
						options: {
							root: filePaths.root,
							sourceMap: !isProduction,
						},
					},
					{
						loader: 'sass-loader',
						options: {
							sourceMap: true, // required for resolve-url-loader
							sassOptions: {
								includePaths: [filePaths.node, filePaths.cssSrc],
								outputStyle: 'expanded',
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
				type: 'asset/resource',
				generator: {
					filename: `${folders.fonts}/${config.assetname}`,
				},
			},
			{
				test: /\.(png|svg|jpg|jpeg|gif|ico)$/i,
				type: 'asset/resource',
				generator: {
					filename: `${folders.images}/${config.assetname}`,
				},
			},
		],
	},
	resolve: {
		modules: [filePaths.node, filePaths.src],
		enforceExtension: false,
	},
	externals: {},
};

webpackConfig = merge(config.webpack, webpackConfig);

if (isProduction) {
	const ImageMinimizerPlugin = require('image-minimizer-webpack-plugin');
	webpackConfig = merge(webpackConfig, {
		optimization: {
			minimize: true,
			minimizer: [
				'...',
				new ImageMinimizerPlugin({
					minimizer: {
						implementation: ImageMinimizerPlugin.squooshMinify,
					},
				}),
			],
		},
	});
}

exports.baseConfig = webpackConfig;

const startingPlugins = [
	new webpack.ProvidePlugin({
		$: 'jquery',
		jQuery: 'jquery',
		'window.jQuery': 'jquery',
		_: 'lodash',
		bootstrap: 'bootstrap',
		Popper: '@popperjs',
	}),
	new ESLintPlugin({
		failOnWarning: !buildWatch,
		emitError: !isProduction,
		emitWarning: !isProduction,
		formatter: require('eslint-formatter-pretty'),
		fix: true,
	}),
	new StyleLintPlugin({
		failOnError: !buildWatch,
		emitError: !isProduction,
		emitWarning: !isProduction,
		formatter: require('stylelint-formatter-pretty'),
		lintDirtyModulesOnly: true,
		fix: true,
	}),
	new RemoveEmptyScriptsPlugin(),
	new ExtractCssChunks({
		filename: `${folders.css}/${config.filename}.css`,
	}),
	new CleanupMiniCssExtractPlugin(),
];

if (!isEmpty(config.enabled.cache)) {
	endingPlugins.unshift(new webpack.MemoryCachePlugin());
}

exports.startingPlugins = startingPlugins;

const endingPlugins = [
	new WebpackManifestPlugin({
		fileName: filePaths.manifest,
		basePath: '',
		publicPath: '',
		map: (file) => {
			let fileName = !isEmpty(file.name) ? file.name : file.path;
			let ext = path.extname(fileName);
			fileName = path.basename(fileName.replace(/\?.*/gm, ''), ext);
			if (isProduction) {
				fileName = fileName + '.min';
			}
			fileName = fileName + ext;
			file.name = fileName;
			return file;
		},
		filter: (file) => {
			let fileName = !isEmpty(file.name) ? file.name : file.path;
			fileName = path.basename(fileName.replace(/\?.*/gm, ''));
			let pattern = /\.(map)$/i;
			return pattern.test(fileName) != true;
		},
		seed: manifest,
		removeKeyHash: true,
	}),
	new FriendlyErrorsWebpackPlugin({
		logLevel: buildWatch ? 'SILENT' : 'WARNING',
		clearConsole: true,
		additionalTransformers: [require('./transformers/sassError.js')],
		onErrors: (severity, errors) => {
			console.log({ severity, errors });
		},
	}),
	new WebpackBuildNotifierPlugin(config.notify),
];

if (!isEmpty(config.copy)) {
	const CopyPlugin = require('copy-webpack-plugin');
	let copyPatterns = [];
	if (_.isArray(config.copy)) {
		_.each(config.copy, function (pattern) {
			if (_.isString(pattern)) {
				pattern = {
					from: pattern,
					to: filePaths.dist,
				};
			}
			_.defaultsDeep(pattern, {
				noErrorOnMissing: true,
				globOptions: {
					gitignore: true,
				},
				transform: {
					cache: true,
				},
			});
			copyPatterns.push(pattern);
		});
	}
	endingPlugins.unshift(
		new CopyPlugin({
			patterns: config.copy,
			options: {
				concurrency: 100,
			},
		})
	);
}

exports.endingPlugins = endingPlugins;
