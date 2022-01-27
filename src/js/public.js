/**
 * ============================================================================
 * plugin
 *
 * @file
 * @package
 * @since     0.1.0
 * @version   0.1.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 RIESTER
 * ==========================================================================
 */

import smoothscroll from 'smoothscroll-polyfill';

/**
 * Better Skip link
 *
 */
function betterHashLinks() {
	const isIe = /(trident|msie)/i.test(navigator.userAgent);
	const motionQuery = window.matchMedia('(prefers-reduced-motion)');

	window.addEventListener(
		'hashchange',
		function () {
			const id = location.hash.substring(1);

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
		false
	);
}

(function () {
	smoothscroll.polyfill();
	betterHashLinks();
	console.log(rwp);
})();
