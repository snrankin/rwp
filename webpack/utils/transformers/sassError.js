/** ============================================================================
 * stylelintError
 *
 * @version   1.0.0
 * @author    Sam Rankin <srankin@riester.com>
 * @copyright 2022 RIESTER
 * ========================================================================== */

const path = require('path');
const _ = require('lodash');
const chalk = require('chalk');
const { removeLoaders, isEmpty, isSassError } = require('../utils');

function cleanMessage(message) {
	let result = message.replace(/(?<=╵)(.|\s)*/i, '');

	return result;
}

function transformSassError(error) {
	let message = _.get(error, 'webpackError.error.originalSassError.message', '');
	let file = _.get(error, 'webpackError.error.originalSassError.file', '');
	let errorLine = _.get(error, 'webpackError.error.originalSassError.line', 0);
	let errorCol = _.get(error, 'webpackError.error.originalSassError.column', 0);
	let col = _.toString(errorCol);
	message = cleanMessage(message);
	message = message.split('\n');
	let errorTitle = message.shift();
	errorTitle = errorTitle.replace('.', ':');

	_.each(message, function (line, index) {
		let padding = col.length + 1;
		if (/^\d/.test(line)) {
			let lineLocation = chalk.gray(`${errorLine}:${errorCol}`);
			line = line.replace(/\d+(\s│\s)*/i, '');
			line = `${lineLocation} │ ${chalk.bold(errorTitle)} ${line}`;
			line = `\t${line}`;
		} else if (/\^+/.test(line)) {
			padding = padding + line.length + 1;
			let innerPadding = _.repeat(' ', errorTitle.length);

			line = _.padStart(line, padding);
			line = line.replace(/(?<=│)(\s+)(\^+)/i, `$1${innerPadding}$2`);
			line = line.replace('│', ' ');
			line = `\t${line}`;
			chalk.underline(line);
		} else {
			line = '';
		}

		message[index] = line;
	});
	message = _.reject(message, isEmpty);
	message = message.join('\n');
	file = path.relative(process.cwd(), file);

	file = `${file}:${errorLine}`;
	return _.defaultsDeep(
		{
			message,
			file,
		},
		error
	);
}

function transform(error) {
	error = removeLoaders(error);

	if (isSassError(error)) {
		error = transformSassError(error);
	}

	let errorMessage = _.get(error, 'webpackError.message', '');
	let miniCSSModule = errorMessage.indexOf('mini-css-extract-plugin');
	let isMiniCSS = miniCSSModule > -1;
	if (isMiniCSS) {
		error.message = '';
	}

	return error;
}

module.exports = transform;
