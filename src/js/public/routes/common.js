/** ============================================================================
 * Public: common scripts
 *
 * @version   1.0.1
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2022 RIESTER
 * ========================================================================== */

import smoothscroll from 'smoothscroll-polyfill';
import { betterHashLinks } from '../../util/utils';

export default {
	init() {
		// JavaScript to be fired on the home page
	},
	finalize() {
		// JavaScript to be fired on the home page, after the init JS
		smoothscroll.polyfill();
		window.addEventListener(betterHashLinks);
		console.log(rwp);
	},
};
