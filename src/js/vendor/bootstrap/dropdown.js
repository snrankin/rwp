/** ============================================================================
 * dropdown
 *
 * @version   1.0.1
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2022 RIESTER
 * ========================================================================== */

import /* webpackMode: "eager" */ * as hoverintent from 'hoverintent';
import { /* webpackMode: "eager" */ /* webpackExports: ["Dropdown"] */ Dropdown } from 'bootstrap';

const CLASS_NAME = 'has-child-dropdown-show';

function focusIn(event) {
	if (event.type === 'focus' || event.type === 'focusin') {
		let self = event.target;

		if (self.hasAttribute('data-bs-toggle')) {
			self.classList.add('focus');
		}
		// Move up through the ancestors of the current link until we hit .nav-menu.
		while (!self.classList.contains('menu')) {
			// On li elements toggle the class .focus.
			if ('li' === self.tagName.toLowerCase()) {
				self.classList.add('focus');
			}
			self = self.parentNode;
		}
	}
}
function focusOut(event) {
	if (event.type === 'blur' || event.type === 'focusout') {
		let self = event.target;

		// Move up through the ancestors of the current link until we hit .nav-menu.
		while (!self.classList.contains('menu')) {
			// On li elements toggle the class .focus.
			if ('li' === self.tagName.toLowerCase()) {
				self.classList.remove('focus');
			}
			self = self.parentNode;
		}
	}
}

function openSubMenu(event) {
	const elem = event.target;
	const parent = 'li' !== elem.tagName.toLowerCase() ? elem.closest('.dropdown') : elem;
	const toggle = 'button' !== elem.tagName.toLowerCase() ? parent.querySelector(':scope>[data-bs-toggle="dropdown"]') : elem;
	const target = parent.querySelector(':scope>.dropdown-menu');

	if (!target.classList.contains('show')) {
		Dropdown.getOrCreateInstance(toggle).toggle();
		parent.classList.add(CLASS_NAME);
		Dropdown.clearMenus(event);
	}
}
function closeSubMenu(event) {
	const elem = event.target;
	const parent = 'li' !== elem.tagName.toLowerCase() ? elem.closest('.dropdown') : elem;
	const toggle = 'button' !== elem.tagName.toLowerCase() ? parent.querySelector(':scope>[data-bs-toggle="dropdown"]') : elem;
	const target = parent.querySelector(':scope>.dropdown-menu');

	if (target.classList.contains('show')) {
		Dropdown.getOrCreateInstance(toggle).toggle();
		parent.classList.remove(CLASS_NAME);
	}
}

function addToggleFocus() {
	// Get all the link elements within the menu.
	const links = document.querySelectorAll('li:not(.has-children) > .menu-link');
	links.forEach((link) => {
		link.addEventListener('focus', focusIn, true);
		link.addEventListener('blur', focusOut, true);
	});

	const toggles = document.querySelectorAll('.menu-toggle');
	toggles.forEach((toggle) => {
		rwp.listen(toggle, 'focus', openSubMenu, true);
	});
}

function initDropDown() {
	Dropdown.prototype.toggle = (function (_orginal) {
		return function () {
			document.querySelectorAll('.' + CLASS_NAME).forEach(function (e) {
				e.classList.remove(CLASS_NAME);
			});
			let dd = this._element.closest('.dropdown').parentNode.closest('.dropdown');
			for (; dd && dd !== document; dd = dd.parentNode.closest('.dropdown')) {
				dd.classList.add(CLASS_NAME);
			}
			return _orginal.call(this);
		};
	})(Dropdown.prototype.toggle);

	document.querySelectorAll('.dropdown').forEach(function (dd) {
		dd.addEventListener('hide.bs.dropdown', function (e) {
			if (this.classList.contains(CLASS_NAME)) {
				this.classList.remove(CLASS_NAME);
				e.preventDefault();
			}
			e.stopPropagation(); // do not need pop in multi level mode
		});
	});

	// for hover
	document.querySelectorAll('.dropdown-hover, .dropdown-hover-all .dropdown').forEach(function (dd) {
		const parent = dd;
		hoverintent(
			dd,
			function (e) {
				parent.classList.add('hover');
				openSubMenu(e);
			},
			function (e) {
				parent.classList.remove('hover');
				closeSubMenu(e);
			}
		).options({
			timeout: 300,
			interval: 200,
			sensitivity: 10,
		});
	});

	addToggleFocus();
}

export { initDropDown, Dropdown };
