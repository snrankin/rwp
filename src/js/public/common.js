/** ============================================================================
 * Public: common scripts
 *
 * @version   0.9.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2022 RIESTER
 * ========================================================================== */

import { /* webpackChunkName: "vendors" */ polyfill as smoothscroll } from 'smoothscroll-polyfill';
rwp = typeof rwp === 'undefined' ? {} : rwp;

export default {
	betterHashLinks() {
		const id = location.hash.substring(1);

		if (!/^[A-z0-9_-]+$/.test(id)) {
			return;
		}

		const element = document.getElementById(id);

		if (element) {
			if (!/^(?:a|select|input|button|textarea)$/i.test(element.tagName)) {
				element.tabIndex = -1;
			}

			if (!rwp.isReduced) {
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

	setupOffcanvasNav() {
		const elements = document.querySelectorAll('.offcanvas-toggle');
		var matches = Array.from(elements);

		if (matches.length > 0) {
			matches.forEach(function (el) {
				el.addEventListener('click', function () {
					el.classList.toggle('active');
				});
			});
		}
		let navbar = document.querySelector('.navbar');
		let header = navbar.closest('header');
		if (!rwp.isEmpty(navbar)) {
			let navbarClasses = navbar.getAttribute('class');

			const regex = new RegExp('navbar-expand-(\\w+)', 'gm');
			let breakpointClass = false;

			if (regex.test(navbarClasses)) {
				breakpointClass = navbarClasses.match(regex);
				breakpointClass = breakpointClass[0];
				breakpointClass = breakpointClass.split('-');
				breakpointClass = breakpointClass.slice(-1).pop();
			}

			rwp.addHeaderOffset('.navbar .offcanvas', header, true, 'marginTop', breakpointClass, 'max-width');
		}
	},
	resize() {},
	init() {
		// JavaScript to be fired on the home page
		smoothscroll();
	},
	finalize() {
		// JavaScript to be fired on the home page, after the init JS
		this.setupOffcanvasNav();
		$('.screen-full').width(rwp.screenSize('width')).height(rwp.screenSize('height'));
		$('.screen-width').width(rwp.screenSize('width'));
		$('.screen-height').height(rwp.screenSize('height'));
		window.addEventListener('click', this.betterHashLinks);
	},
};
