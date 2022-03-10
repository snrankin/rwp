/** ============================================================================
 * stylelintError
 *
 * @version   1.0.0
 * @author    Sam Rankin <srankin@riester.com>
 * @copyright 2022 RIESTER
 * ========================================================================== */

const path = require('path');
const _ = require('lodash');
function isSassError(e) {
	return e.originalStack.some((stackframe) => stackframe.fileName && stackframe.fileName.indexOf('sass-loader') > 0);
}
exports.isSassError = isSassError;

function cleanMessage(message, line = 0) {
	message = message.replace(/^Error*:\s/, '');

	message = message.replace(/(.*\n.*)(?=of)(of\s)(.*[^\n])((\n|.)*)/m, `$1$2$3:${line}$4`);

	return message;
}

function transform(error) {
	if (isSassError(error)) {
		let message = _.get(error, 'webpackError.error.originalSassError.formatted', '');
		let file = _.get(error, 'webpackError.error.originalSassError.file', '');
		let line = _.get(error, 'webpackError.error.originalSassError.line', 0);

		message = cleanMessage(message, line, file);
		file = path.relative(process.cwd(), file);
		let e = Object.assign({}, error, {
			message,
			file,
		});

		return e;
	}

	return error;
}

module.exports = transform;
