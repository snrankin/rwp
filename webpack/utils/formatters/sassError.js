/** ============================================================================
 * sassErrors
 *
 * @version   1.0.1
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2022 RIESTER
 * ========================================================================== */
const _ = require('lodash');
const { concat } = require('@soda/friendly-errors-webpack-plugin/src/utils');

const { removeLoaders, isEmpty, isSassError } = require('../utils');

function displayError(error) {
	return [error.message, ''];
}

function format(errors) {
	let sassErrors = _.reject(errors, function (error) {
		return isEmpty(error.message) || !isSassError(error);
	});
	if (!isEmpty(sassErrors)) {
		sassErrors = _.map(errors, removeLoaders);

		sassErrors = _.uniqWith(errors, function (arrVal, othVal) {
			if (!isEmpty(arrVal.origin) && !isEmpty(othVal.origin)) {
				return arrVal.origin === othVal.origin;
			}
			return arrVal.file === othVal.file;
		});
		if (sassErrors.length > 0) {
			const flatten = (accum, curr) => accum.concat(curr);
			return concat(sassErrors.map((error) => displayError(error)).reduce(flatten, []));
		}
	}

	return [];
}

module.exports = format;
