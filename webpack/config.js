/**
 * ============================================================================
 * config
 *
 * @since     0.1.0
 * @version   0.1.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2021 RIESTER
 * ==========================================================================
 */

const _ = require('lodash');
const path = require('path');
const pkg = require('../package.json');
const { argv } = require('yargs');

const config = require('../config.json');

const isProduction = !_.isNil(argv.p) ? true : false;
const rootPath =
	config.paths && config.paths.root ? config.paths.root : process.cwd();

const buildWatch = !_.isNil(argv.watch) ? true : false;

let buildStats = {
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
};

if (!buildWatch && config.enabled.debug) {
	buildStats = 'verbose';
}

const fileNames = (groupName = 'main', configName = '') => {
	let entry = config.entry;

	if (_.isString(groupName) && groupName !== '' && _.has(entry, groupName)) {
		entry = entry[groupName].files;

		if (
			_.isString(configName) &&
			configName !== '' &&
			_.has(entry, configName)
		) {
			entry = entry[configName];
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

const createConfig = (groupName = '', configName = '') => {
	const subName = configName || argv.name;
	const entryFiles = fileNames(groupName, configName);
	let customConfig = {};
	if (
		_.isString(groupName) &&
		groupName !== '' &&
		_.has(config.entry, groupName)
	) {
		customConfig = config.entry[groupName];
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

		const wpContentDirIndex = _.indexOf(publicPath, 'wp-content');

		if (wpContentDirIndex > -1) {
			publicPath = _.slice(publicPath, wpContentDirIndex);
		}
		publicPath = '/' + _.join(publicPath, '/') + '/';
		customConfig.paths.public = publicPath;
	} else {
		customConfig.paths.public += '/';
	}

	let filenameTemplate = customConfig.enabled.cachebusting
		? `${fileprefix}${customConfig.cachebusting}`
		: `${fileprefix}[name]`;

	if (isProduction) {
		filenameTemplate = filenameTemplate + '.min';
	}

	const assetnameTemplate = customConfig.enabled.cachebusting
		? `${customConfig.cachebusting}[ext][query]`
		: '[hash][ext][query]';

	let newConfig = {
		webpack: {
			mode: isProduction ? 'production' : 'development',
			entry: entryFiles,
			context: customConfig.paths.src || rootPath,
			output: {
				path: customConfig.paths.dist,
				publicPath: customConfig.paths.public,
				filename: path.join(
					customConfig.folders.js,
					`${filenameTemplate}.js`
				),
				assetModuleFilename: path.join(
					customConfig.folders.images,
					assetnameTemplate
				),
			},
			stats: buildStats,
			watchOptions: {
				ignored: [
					'**/*.php',
					'**/*.json',
					'node_modules/**',
					config.paths.dist,
					path.join(distRel, '**'),
					path.join(rootPath, 'node_modules'),
				],
			},
		},
		filename: filenameTemplate,
		assetname: assetnameTemplate,
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
									'(-[^-\\/]+)?.css(.map)?(.min)?$',
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
									'(-[^-\\/]+)?.(js|php)(.map)?(.min)?$',
								'g'
							);

							return pattern.test(absoluteItemPath);
						},
						recursive: true,
					},
				],
			},
		},
	};

	if (config.enabled.sourcemaps) {
		newConfig.webpack.devtool = 'source-map';
	}

	newConfig = _.defaultsDeep(newConfig, customConfig);

	if (!_.isNil(configName) && _.isString(configName) && configName !== '') {
		newConfig = _.merge({ webpack: { name: configName } }, newConfig);
	}

	return newConfig;
};

exports.createConfig = createConfig;
