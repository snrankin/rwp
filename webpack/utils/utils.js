/** ============================================================================
 * utils
 *
 * @version   1.0.0
 * @author    Sam Rankin <srankin@riester.com>
 * @copyright 2022 RIESTER
 * ========================================================================== */

const _ = require('lodash');
const fs = require('fs');
const path = require('path');
const util = require('util');
const config = require('../../config.json');
const rootPath = config.paths && config.paths.root ? config.paths.root : process.cwd();
const { argv } = require('yargs');
const sassType = RegExp('scss$');
const isSassError = (e) => {
	let file = _.get(e, 'file', '');
	let isSassFile = sassType.test(file);

	let errorMessage = _.get(e, 'webpackError.message', '');
	let miniCSSModule = errorMessage.indexOf('mini-css-extract-plugin');
	let isNotMiniCSS = miniCSSModule == -1;
	return isSassFile && isNotMiniCSS;
};
exports.isSassError = isSassError;

const sortObjectByKeys = (o) => {
	return Object.keys(o)
		.sort()
		.reduce((r, k) => ((r[k] = o[k]), r), {});
};
exports.sortObjectByKeys = sortObjectByKeys;

/**
 * Get the current enviornment
 *
 * @return {*}
 */
const env = () => {
	if (_.has(argv, 'mode')) {
		return argv.mode;
	} else if (_.has(argv, 'env')) {
		return argv.env;
	} else if (_.has(argv, 'p')) {
		return 'production';
	}
	return 'development';
};

exports.env = env;

const folders = _.get(config, 'folders', {});
exports.folders = folders;

/**
 * Formats all the paths in config.json into absolute paths
 *
 * @return {Object}
 */

let paths = config.paths;
paths.root = rootPath;
paths.node = path.join(rootPath, 'node_modules');
paths.src = path.join(rootPath, folders.src);
paths.dist = path.join(rootPath, folders.dist);

let fileFolders = _.transform(
	folders,
	function (result, value, key) {
		if ('src' !== key && 'dist' !== key) {
			let distFolder = folders.dist;
			let srcFolder = folders.src;
			let publicFolder = '';
			let publicPath = paths.public;

			result[key] = {
				dist: path.join(rootPath, distFolder, value),
				src: path.join(rootPath, srcFolder, value),
				public: publicPath + path.join(publicFolder, value),
			};
		}
	},
	{}
);

_.defaultsDeep(paths, fileFolders);

const filePaths = _.transform(
	paths,
	function (result, value, key) {
		if ('public' !== key) {
			if (_.isString(value)) {
				result[key] = path.resolve(rootPath, value);
			} else {
				result[key] = _.transform(value, function (r, v, k) {
					r[k] = path.resolve(rootPath, v);
				});
			}
		} else {
			result[key] = paths.public;
		}
	},
	{}
);
filePaths.distRel = path.relative(rootPath, filePaths.dist);

exports.filePaths = filePaths;

/**
 * Get the manifest file if it exists
 *
 * @return {Object}
 */

let manifestSeed = {};
let manifestPath = _.get(filePaths, 'manifest', '');
if (fs.existsSync(manifestPath)) {
	let rawdata = fs.readFileSync(manifestPath);
	manifestSeed = JSON.parse(rawdata);
}

exports.manifest = manifestSeed;

/**
 * Get the file name from the manifest
 *
 * @param {string} filename
 * @return {string}
 */
const filenameHelper = (filename) => {
	filename = path.basename(filename);
	filename = _.replace(filename, '.scss', '.css');
	if (!isEmpty(filename)) {
		if (_.has(manifestSeed, filename)) {
			return _.get(manifestSeed, filename);
		} else {
			return filename;
		}
	} else {
		return filename;
	}
};

exports.filenameHelper = filenameHelper;

const sortArray = (arr1, arr2) => {
	arr2.sort((a, b) => {
		const aKey = Object.keys(a)[0];
		const bKey = Object.keys(b)[0];
		return arr1.indexOf(aKey) - arr1.indexOf(bKey);
	});
};
exports.sortArray = sortArray;

/**
 * Nicer looking console.log helper
 *
 * @param {*} debug_item
 */
const debug = (debug_item) => {
	console.log(
		util.inspect(debug_item, {
			depth: 8,
			colors: true,
		})
	);
};
exports.debug = debug;

/**
 * Check if a variable is empty
 *
 * @export
 * @param {*} el The variable to check
 * @return {boolean} True if empty, false if not
 */
const isEmpty = (el) => {
	if (_.isNull(el) || _.isUndefined(el)) {
		return true;
	} else if (_.isString(el) && el.length == 0) {
		return true;
	} else if (_.isObject(el) && _.isEmpty(el)) {
		return true;
	}
	return false;
};

exports.isEmpty = isEmpty;

/**
 * Convert a string to slug or kebab case
 *
 * @param {*} str
 * @return {*}
 */

const slugCase = (str) => {
	let pattern = new RegExp('((s+&s+)|(s+&amp;s+))');
	str = _.replace(str, pattern, ' and ');
	return _.chain(str).deburr().trim().kebabCase().value();
};
exports.slugCase = slugCase;

/**
 * Convert a string to title case with ampersands
 *
 * @param {*} str
 * @return {*}
 */
const titleCase = (str) => {
	let pattern = new RegExp(/(\/|-|_)/gm);
	str = _.replace(str, pattern, ' ');
	str = _.chain(str)
		.trim()
		.startCase()
		.tap(function (str) {
			let andPattern = new RegExp(/and/gim);
			var amp = _.escape('&');
			return _.replace(str, andPattern, amp);
		})
		.value();
	return str;
};
exports.titleCase = titleCase;

const pathByType = (file = '') => {
	let cssPattern = new RegExp(/\.(sc|sa|c)ss$/);
	let jsPattern = new RegExp(/\.js$/);
	let imagesPattern = new RegExp(/\.(png|svg|jpg|jpeg|gif|ico)$/);
	let fontsPattern = new RegExp(/\.(woff|woff2|eot|ttf|otf)$/);

	let folderType = '';

	if (cssPattern.test(file)) {
		folderType = folders.css;
	} else if (jsPattern.test(file)) {
		folderType = folders.js;
	} else if (imagesPattern.test(file)) {
		folderType = folders.images;
	} else if (fontsPattern.test(file)) {
		folderType = folders.fonts;
	}

	if (typeof folderType === 'string' && !isEmpty(folderType)) {
		file = './' + path.join(folderType, file);
	}

	return file;
};

const blockPath = (file = '') => {
	return './' + path.join('blocks', file, 'index.js');
};

const getPathFromUrl = (url) => {
	return url.split('?')[0];
};

exports.getPathFromUrl = getPathFromUrl;

/**
 * Extracts the entry object from the config.json file with group set webpack args
 *
 * @param {string} [groupName='']
 * @param {string} [configName='']
 * @param {Object} [entry={}] The entry object
 * @return {*}
 */
const fileNames = (groupName = '', configName = '', entry = {}) => {
	if (!isEmpty(groupName)) {
		if (_.has(entry, groupName)) {
			entry = _.get(entry, `${groupName}.files`, {});
		}

		if (!isEmpty(configName) && groupName !== 'blocks' && _.has(entry, configName)) {
			entry = _.get(entry, configName, {});
		} else if (!isEmpty(configName) && groupName === 'blocks' && _.indexOf(configName) != '-1') {
			let index = _.indexOf(configName);
			entry = [entry[index]];
		} else if (groupName !== 'blocks') {
			entry = _.reduce(
				entry,
				function (result, value, key) {
					if (_.isString(value)) {
						_.merge(result, {
							[key]: value,
						});
					} else if (_.isObject(value)) {
						_.merge(result, value);
					}

					return result;
				},
				{}
			);
		}
	} else {
		if (groupName !== 'blocks') {
			entry = _.reduce(
				entry,
				function (result, value) {
					_.merge(result, value.files);
					return result;
				},
				{}
			);

			entry = _.reduce(
				entry,
				function (result, value, key) {
					if (_.isString(value)) {
						_.merge(result, {
							[key]: value,
						});
					} else if (_.isObject(value)) {
						_.merge(result, value);
					}

					return result;
				},
				{}
			);
		}
	}

	if (groupName !== 'blocks') {
		entry = _.mapValues(entry, function (value) {
			if (_.isString(value)) {
				value = pathByType(value);
			} else {
				if (_.isObject(value) && _.has(value, 'import')) {
					if (_.isArray(value.import)) {
						_.each(value.import, function (file, fileKey) {
							value.import[fileKey] = pathByType(file);
						});
					}
					if (_.isString(value.import)) {
						value.import = pathByType(value.import);
					}
				} else if (_.isArray(value)) {
					_.each(value, function (file, fileKey) {
						value[fileKey] = pathByType(file);
					});
				}
			}

			return value;
		});
	} else {
		entry = _.keyBy(entry, function (value) {
			return value;
		});
		entry = _.mapValues(entry, function (value) {
			return blockPath(value);
		});
	}

	return entry;
};

exports.fileNames = fileNames;

const copyPath = (file, filePath = '') => {
	if (!isEmpty(file)) {
		let packagePath = path.dirname(file);

		let name = path.basename(file);

		return path.join(filePaths.node, filePath, packagePath, name);
	} else {
		return '';
	}
};

exports.copyPath = copyPath;

const removeLoaders = (error) => {
	let file = _.get(error, 'file', '');
	if (!file) {
		return '';
	}
	const split = file.split('!');
	const filePath = split[split.length - 1];
	_.set(error, 'file', filePath);
	return error;
};

exports.removeLoaders = removeLoaders;
