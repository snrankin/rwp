/** ============================================================================
 * utils
 *
 * @since     1.0.0
 * @version   1.0.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2021 RIESTER
 * ========================================================================== */
const util = require('util');

const rwpDebug = (debugItem) => {
	//eslint-disable-next-line
	console.log(util.inspect(debugItem, false, null, true /* enable colors */));
};
exports.rwpDebug = rwpDebug;
