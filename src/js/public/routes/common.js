/** ============================================================================
 * Public: common scripts
 *
 * @version   1.0.1
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2022 RIESTER
 * ========================================================================== */

import smoothscroll from 'smoothscroll-polyfill';

export default {
	betterHashLinks() {
		const id = location.hash.substring(1);
		const motionQuery = window.matchMedia('(prefers-reduced-motion)');

		if (!/^[A-z0-9_-]+$/.test(id)) {
			return;
		}

		const element = document.getElementById(id);

		if (element) {
			if (!/^(?:a|select|input|button|textarea)$/i.test(element.tagName)) {
				element.tabIndex = -1;
			}

			if (!motionQuery.matches) {
				element.scrollIntoView({
					behavior: 'smooth',
				});
			}

			if (element.is(':focus')) {
				//checking if the target was focused
				return false;
			} else {
				element.attr('tabindex', '-1'); //Adding tabindex for elements not focusable
				element.focus(); //Setting focus
			}
		}
	},
	init() {
		// JavaScript to be fired on the home page
	},
	finalize() {
		// JavaScript to be fired on the home page, after the init JS
		smoothscroll.polyfill();
		window.addEventListener('click', this.betterHashLinks);

		$('.screen-full').width(rwp.screenSize('width')).height(rwp.screenSize('height'));
		$('.screen-width').width(rwp.screenSize('width'));
		$('.screen-height').height(rwp.screenSize('height'));
	},
};
