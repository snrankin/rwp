/** ============================================================================
 * config
 *
 * @package   RWP
 * @since     0.1.0
 * @version   0.1.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2021 RIESTER
 * ========================================================================== */

const _ = require('lodash');
const path = require('path');
const pkg = require('../package.json');
const { argv } = require('yargs');

const config = require('./config.json');

const isProduction = config.enabled.production;
const rootPath =
	config.paths && config.paths.root ? config.paths.root : process.cwd();

const fileNames = (configName = 'main', name = '') => {
	let entry = config.entry;

	if (
		_.isString(configName) &&
		configName !== '' &&
		_.has(entry, configName)
	) {
		entry = entry[configName].files;

		if (_.isString(name) && name !== '' && _.has(entry, name)) {
			entry = entry[name];
		} else {
			entry = _.reduce(
				entry,
				function (result, value) {
					_.merge(result, value);
					return result;
				},
				{}
			);
		}

		return entry;
	}
};

exports.fileNames = fileNames;

const createConfig = (configName = '', name = '') => {
	const subName = name || argv.name;
	let files = fileNames(configName, name);
	const entryFiles = files;
	let customConfig = {};
	if (_.isString(name) && name !== '' && _.has(config.entry, name)) {
		customConfig = config.entry[name];
		customConfig = _.omit(customConfig, 'files');
	} else if (
		_.isString(configName) &&
		configName !== '' &&
		_.has(config.entry, configName)
	) {
		customConfig = config.entry[configName];
		customConfig = _.omit(customConfig, 'files');
	}

	customConfig = _.defaultsDeep(customConfig, config);
	const fileprefix = !_.isUndefined(customConfig.fileprefix)
		? customConfig.fileprefix
		: `${pkg.name}-`;
	const distRel = path.relative(rootPath, customConfig.paths.dist);

	customConfig.paths.root = rootPath;
	customConfig.paths = _.transform(
		customConfig.paths,
		function (result, value, key) {
			result[key] = path.resolve(rootPath, value);
		},
		{}
	);

	if (_.isNil(customConfig.paths.public)) {
		let publicPath = _.split(process.cwd(), path.sep);
		publicPath.push(customConfig.folders.dist);

		let wpContentDirIndex = _.indexOf(publicPath, 'wp-content');

		if (wpContentDirIndex > -1) {
			publicPath = _.slice(publicPath, wpContentDirIndex);
		}
		publicPath = '/' + _.join(publicPath, '/') + '/';
		customConfig.paths.public = publicPath;
	} else {
		customConfig.paths.public += '/';
	}

	let notifyTitle = `${pkg.displayName} Build:`;

	if ('' !== configName) {
		notifyTitle += ` ${_.capitalize(configName)}`;
	}

	if ('' !== name) {
		notifyTitle += ` - ${_.capitalize(name)}`;
	}

	let notifyConfig = {
		appName: pkg.displayName,
		title: notifyTitle,
		buildSuccessful: true,
	};

	if (!_.isNil(customConfig.paths.favicon)) {
		notifyConfig.logo = customConfig.paths.favicon;
	}

	let filename = customConfig.enabled.cachebusting
		? `${fileprefix}${customConfig.cachebusting}`
		: `${fileprefix}[name]`;
	let newConfig = {
		webpack: {
			name: name,
			mode: isProduction ? 'production' : 'development',
			entry: files,
			context: customConfig.paths.src || rootPath,
			devtool: customConfig.enabled.sourcemaps ? 'source-map' : 'none',
			output: {
				path: customConfig.paths.dist,
				publicPath: customConfig.paths.public,
				filename: path.join(customConfig.folders.js, `${filename}.js`),
			},
			stats: config.enabled.debug
				? 'verbose'
				: {
						children: false,
						chunks: false,
						colors: true,
						entrypoints: true,
						errorDetails: false,
						errors: false,
						excludeAssets: ['**.map'],
						hash: false,
						modules: false,
						publicPath: false,
						reasons: false,
						source: false,
						timings: false,
						version: false,
						warnings: false,
				  },
			watchOptions: {
				ignored: [
					'**/*.php',
					'node_modules/**',
					'**/*.json',
					path.join(distRel, '**'),
				],
			},
		},
		filename: filename,
		prefix: fileprefix,
		env: Object.assign(
			{ production: isProduction, development: !isProduction },
			argv.env
		),
		clean: {
			before: {
				root: customConfig.paths.dist,
				test: [
					{
						folder: customConfig.folders.css,
						method: (absoluteItemPath) => {
							const absoluteItem = absoluteItemPath;
							const files = _.keys(entryFiles);
							let itemName = '';
							if (
								_.isString(subName) &&
								subName !== '' &&
								_.includes(files, subName)
							) {
								itemName = files[_.indexOf(files, subName)];
							} else {
								const filesNames = _.filter(files, (file) => {
									return _.includes(absoluteItem, file);
								});

								if (!_.isEmpty(filesNames)) {
									itemName = _.head(filesNames);
								}
							}

							const pattern = new RegExp(
								fileprefix +
									itemName +
									'(-[^-\\/]+)?.css(.map)?$',
								'g'
							);

							return pattern.test(absoluteItemPath);
						},
						readWebpackConfiguration: true,
						recursive: true,
					},
					{
						folder: customConfig.folders.js,
						method: (absoluteItemPath) => {
							const absoluteItem = absoluteItemPath;
							const files = _.keys(entryFiles);
							let itemName = '';
							if (
								_.isString(subName) &&
								subName !== '' &&
								_.includes(files, subName)
							) {
								itemName = files[_.indexOf(files, subName)];
							} else {
								const filesNames = _.filter(files, (file) => {
									return _.includes(absoluteItem, file);
								});

								if (!_.isEmpty(filesNames)) {
									itemName = _.head(filesNames);
								}
							}

							const pattern = new RegExp(
								fileprefix +
									itemName +
									'(-[^-\\/]+)?.(js|php)(.map)?$',
								'g'
							);

							return pattern.test(absoluteItemPath);
						},
						recursive: true,
					},
				],
			},
		},
		notify: notifyConfig,
		cacheloader: customConfig.enabled.cache
			? [
					{
						loader: 'cache-loader',
						options: {
							cacheDirectory: customConfig.paths.cache,
						},
					},
			  ]
			: [],
	};

	newConfig = _.defaultsDeep(newConfig, customConfig);

	return newConfig;
};

exports.createConfig = createConfig;
